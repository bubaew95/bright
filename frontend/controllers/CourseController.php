<?php

namespace frontend\controllers;
use Yii;
use yii\filters\VerbFilter;
use common\models\DzhJoincourse;
use common\models\DzhCourse;
use common\models\DzhQuestion;
use common\models\DzhMade; 
use common\models\DzhTestquest; 
use common\models\DzhComments;
use yii\web\NotFoundHttpException;

class CourseController extends AppController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' =>  true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'joincourse' => ['POST'],
                    'made' => ['POST'],
                ],
            ],
        ];
        parent::behaviors();
    }

    public function actionIndex()
    { 
        $this->setMeta('Все курсы');
        $query = DzhCourse::find()->where(['visible' => '0'])->asArray()->orderBy(['id' => SORT_DESC]);
        $pages = $this->getPagination($query);
        $courses = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index', compact('courses', 'pages'));
    }

    //Информация о Курсе
    public function actionView($id)
    {
        $join = [];
        $course = $this->findDataOne((int) $id);
         
        if(empty($course) ) {
            throw new NotFoundHttpException('Такого курса не существует!');
        }
		$this->setMeta($course->name, $course->keywords, $course->description);
        $maybes = $this->getMaybe($id); 
        if(isset(Yii::$app->user->identity->id))  $join = $this->getJoined($course->id);
        return $this->render('view', compact('course', 'join', 'maybes'));
    }

    //Возможно интересные статьи
    private function getMaybe($id)
    {
        return DzhCourse::find()
                ->select(['id', 'name', 'alias', 'img', 'description'])
                ->asArray()
                ->where(['!=', 'id', (int)$id])
                ->andWhere(['visible' => '0'])
                ->limit(3)
                ->all();
    }

    //Открыть курс
    public function actionTodo($alias, $id_course)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if(empty($alias) || empty($id_course)) {
            throw new NotFoundHttpException('Вы не передали обязательные параметры!');
        }
        // $model = DzhCourse::findOne($id_course);
        $model = $this->loadCourse((int)$id_course);
        //Исправил ****
        if( empty($model->isJoining->actived) &&
            $model->id_user != Yii::$app->user->identity->id) {
            return $this->goHome();
        }

        $this->setMeta($model->name . ' | Вопросы из курса');
        $selectWeek = Yii::$app->request->get('id_week');
        $url = Yii::$app->request->queryParams;
        if(empty($selectWeek) && !$selectWeek = $model->weeks[0]->id) { 
            return $this->render('notcourse');
        }
        $questions = $this->getQuestions($selectWeek);
        $isExamine = $this->isExamine($id_course, $selectWeek);
        return $this->render('todo', compact('model', 'selectWeek', 'url', 'questions', 'statistic', 'isExamine'));
    }

    private function loadCourse($id_course)
    {
        return DzhCourse::find()
            ->where(['id' => (int) $id_course])
            ->andWhere([ 'or',
                ['visible' => '0'],
                ['moderation' => '1']
            ])->one();
    }

    //Проверка на сушествование экзаменов 
    private function isExamine($id_course, $selectWeek)
    {
        return DzhTestquest::find()
                ->select(['id'])
                ->where('id_course=:id_course and id_week=:id_week', [
                    ':id_course' => (int)$id_course,
                    ':id_week' => (int)$selectWeek
                ])
                ->asArray()
                ->one();
    }

    //Получение всех вопросов и ответов
    private function getExamine($id_course, $id_examine)
    {
        $sql = "SELECT q.id, q.name, q.id_course, a.isCorrect, q.id_week, a.id, a.id_quest, a.answer FROM `dzh_testquest` q ";
        $sql .= "INNER JOIN `dzh_testanswer` a ON q.id = a.id_quest ";
        $sql .= "WHERE q.id_course = ". (int)$id_course . " AND q.id_week = ".(int)$id_examine." order by rand(a.answer)";
        $quests = DzhTestquest::findBySql($sql)->asArray()->all();
        //dump($quests);
        $arr = [];
        foreach($quests as $quest) {
            if( !$quest['id_quest'] ) return false;
            $arr[$quest['id_quest']][0] = $quest['name'];
            $arr[$quest['id_quest']][$quest['id']] = $quest['answer'];
        }
        return $arr;
    }

    public function actionProgress($id_course)
    {
        $this->setMeta('Процесс прохождения курса');
        $url = Yii::$app->request->queryParams;
        $statistic = $this->getStatistic($id_course);   //Количество ответов и вопрос 
        return $this->render('progress', compact('url', 'statistic'));
    }
 
    private function getStatistic($id_course)
    {
        $sql = "select count(q.id) as countQuestion, ";
        $sql .= "(select count(m.id) from `dzh_made` m where m.id_course = ".(int)($id_course)." and m.id_user = ".Yii::$app->user->identity->id.") as countMade ";
        $sql .= "from `dzh_question` as q "; 
        $sql .= "where q.id_parent != 0 and q.id_course = ". (int)$id_course; 
        return DzhQuestion::findBySql($sql)->asArray()->one();
    } 

    //Проверка правильности тестов
    private function getArrayExamine($id_course, $id_week)
    {
        $sql = "SELECT a.id, a.answer, a.isCorrect, a.id_quest, a.what_is_answer FROM `dzh_testquest` q ";
        $sql .= "LEFT JOIN `dzh_testanswer` a ON q.id = a.id_quest ";
        $sql .= "WHERE q.id_course = ".(int)$id_course." and q.id_week = ".(int) $id_week." and a.isCorrect = '1'";
        return DzhTestquest::findBySql($sql)->asArray()->all();
    }

    //Проверка правильности ответов экзамена
    public function actionCheckexamine()
    {
        if(Yii::$app->request->post() && Yii::$app->request->isAjax) {
            $idCourse   = Yii::$app->request->post('idCourse');
            $idWeek   = Yii::$app->request->post('idWeek');
            $quest      = Yii::$app->request->post('quest');
            $exms       = $this->getArrayExamine($idCourse, $idWeek); 
            $count      = empty($exms) ? 1 : count($exms);
            $score      = 0;  
            foreach($exms as $key => $exm) {
                if($quest[$exm['id_quest']] == $exm['id']) {
                    $score++;
                }
            }
            echo json_encode([ 
                'checkAnswer' => $score,
                'percent' => ceil($score * 100 / $count ),
                'answers' => $exms,
                'nocorrect' => $quest, 
            ]);
            exit;
        }
    }

    //Открыть экзамен
    public function actionExamine($id_examine, $alias, $id_course)
    {
        if(empty($id_examine) || empty($alias) || empty($id_course)) {
            throw new NotFoundHttpException('Вы не передали обязательные параметры!');
        }

        $quest = $this->getExamine($id_course, $id_examine);
 
        if(empty($quest)) {
            throw new NotFoundHttpException('Нет тестирования в базе');
        }

        $this->setMeta('Тестирование');
        $url = Yii::$app->request->queryParams;
        return $this->render('examine', [
            'examines' => $quest,
            'url' => $url
        ]);
    }

    //открыть вопрос
    public function actionSteps($alias, $id_course, $id_question)
    {
        /*
            -- следующая запись
            SELECT * FROM tbl WHERE id > $id ORDER BY id ASC LIMIT 1;
            -- предыдущая запись
            SELECT * FROM tbl WHERE id < $id ORDER BY id DESC LIMIT 1;
         */
        if(empty($alias) || empty($id_course) || empty($id_question)) {
            throw new NotFoundHttpException('Вы не передали обязательные параметры!');
        }
        $join = $this->getJoined($id_course);

        if(Yii::$app->user->isGuest || $join['actived'] == "0") {
            return $this->goHome();
        }
        $openQuestion = DzhQuestion::find()->where(['id' => (int)$id_question, 'id_course' => (int)$id_course])->one();
        $this->setMeta($openQuestion->question);

        if(empty($openQuestion)) {
            throw new NotFoundHttpException('Такой записи нет');
        }
        $nextQuest = $this->getNextQuestion($openQuestion->id_week, (int)$id_course, $openQuestion->position);
        $prevQuest = $this->getPrevQuestion($openQuestion->id_week, (int)$id_course, $openQuestion->position);
        $getParams = Yii::$app->request->queryParams;

        //$this->getExamine($id_course, $selectWeek);
        
        $url = Yii::$app->request->queryParams;
        return $this->render('step', compact('openQuestion', 'getParams', 'nextQuest', 'prevQuest', 'url'));
    }

    public function actionLoadComments($id)
    {   
        if(Yii::$app->request->isAjax) {
            $comments = $this->getComments($id); 
            return  \frontend\components\CommentsWidget::widget([
                'tpl' => 'comments', 
                'model' => $comments, 
                'param' => $id]
            );
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    //Вывод комментариев
    private function getComments($id_question)
    {
        return DzhComments::find()
                ->select(['dzh_comments.*', 'dzh_userinfo.fio', 'dzh_userinfo.id_user', 'dzh_userinfo.img', 'dzh_userinfo.color'])
                ->join('INNER JOIN', 'dzh_userinfo','dzh_comments.id_user =dzh_userinfo.id_user')
                ->where(['id_quest' => (int) $id_question])
                ->indexBy('id')
                ->orderBy(['id' => SORT_DESC, 'id_parent'=> SORT_DESC])
                ->asArray()
                ->all();
    }

    //Слудующая запись
    private function getNextQuestion($id_week, $id_course, $position)
    {
        return DzhQuestion::find()
            ->select(['id'])
            ->asArray()
            ->where(['=', 'position', (int)$position + 1])
            ->andWhere(['id_course' => (int)$id_course])
            ->andWhere(['>', 'id_parent', '0'])
            ->andWhere(['id_week' => $id_week])
            ->orderBy(['id' => SORT_ASC])
            ->one();
    }

    //Предедущая запись
    private function getPrevQuestion($id_week, $id_course, $position)
    {
        return DzhQuestion::find()
            ->select(['id'])
            ->asArray()
            ->where(['=', 'position', ((int) $position - 1)])
            ->andWhere(['id_course' => (int)$id_course])
            ->andWhere(['>', 'id_parent', '0'])
            ->andWhere(['!=', 'position', '0'])
            ->andWhere(['id_week' => $id_week])
            ->orderBy(['id' => SORT_DESC])
            ->one();
    }

    private function getQuestions($selectWeek)
    {
        $sql = "select q.id, q.question, q.id_parent, q.answer, (select m.id_course from dzh_made m where m.id_question = q.id and m.id_user = ".Yii::$app->user->identity->id." limit 1) as isMade ";
        $sql .= "from `dzh_question` as q "; 
        $sql .= "where q.id_week = ". (int)$selectWeek;

        $quests = DzhQuestion::findBySql($sql)->indexBy('id')->asArray()->all();
        $tree = [];
        foreach($quests as $key => $quest) {
            if($quest['id_parent'] == 0) {
                $tree[$key] = $quest;
            } else {
                $tree[$quest['id_parent']]['childs'][$quest['id']] = $quest;
            }
        } 
        return $tree;
    }

    //Проверка покупки
    private function getJoined($id)
    {
        $join   = DzhJoincourse::find()
                    ->select(['id', 'actived'])
                    ->asArray()
                    ->where([
                        'id_user'   => Yii::$app->user->identity->id, 
                        'id_course' => (int)$id
                    ])->one();
        return $join;
    }

    //Добавление в подписку
    public function actionJoincourse()
    {  
        if (Yii::$app->user->isGuest) { 
            return $this->redirect(['/login']); //Yii::$app->request->referrer
        }

        $id_course = (int) Yii::$app->request->post("course_id");
        $join = $this->getJoined($id_course);
          
        if(empty($join)) {
            $data      = $this->findDataOne($id_course); 
            $joinAdd   = new DzhJoincourse();
            $joinAdd->id_user       = Yii::$app->user->identity->id;
            $joinAdd->id_course     = (int) $id_course;
            $joinAdd->total_price   = $data->price;
            if($joinAdd->save()) {
                Yii::$app->mailer->compose()
                    ->setTo('bright-school@mail.ru')
                    ->setFrom(['bright-school@mail.ru' => Yii::$app->params['siteName'] . ' робот'])
                    ->setSubject("Подписка к курсу")
                    ->setHtmlBody("Пользователь <b>" . Yii::$app->user->identity->fullname . "</b> подписался на курс <b>" . $data->name . "</b>!")
                    ->send();
            }


        }
        
        return $this->redirect(['payment/course', 'id_course' => $id_course]); 
    }

    //Добавить вопрос в отвеченным
    public function actionMade()
    {
        $idCourse       = Yii::$app->request->post('idCourse');
        $idQuestionurl  = Yii::$app->request->post('idQuestion');
        $idUser         = Yii::$app->user->identity->id;
        $isBool = false;
        if(!empty($idCourse) || !empty($idQuestionurl)) {
            $made = new DzhMade();
            $isMade = $made::find()->where(['id_user' => $idUser, 'id_question' => (int) $idQuestionurl])->one();
            if(!empty($isMade)) {
                $isMade->delete();
                $isBool = false;
            } else {
                /** 
                 * id - Пользователя
                 * idCourse - id курса 
                 * idQuestionurl - id вопроса
                */ 
                $made->saved($idUser, $idCourse, $idQuestionurl);
                $statistic = $this->getStatistic($idCourse);
                if($statistic['countQuestion'] == $statistic['countMade']) {
                    $upd = new \common\models\DzhCompleted();
                    $upd->id_user = Yii::$app->user->identity->id;
                    $upd->id_course = $idCourse;
                    $upd->percent = 100;
                    $upd->comments = "Курс успешно пройден";
                    $upd->save(); 
                }
                $isBool = true;
            }
        }
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $isBool;
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    //Получение данных
    private function findDataOne($id) 
    {
        return DzhCourse::find()->where(['id' => (int) $id])->andWhere(['visible' => '0'])->one();
    }

 
    //Комментарии
    public function actionAddcoments()
    { 
        $idQuestion     = Yii::$app->request->post('idQuestion');
        $text           = Yii::$app->request->post('text');
        $id_parent      = Yii::$app->request->post('id_parent') ? Yii::$app->request->post('id_parent') : 0;
        if(empty($idQuestion)) return;
        
        $model = new DzhComments();
        $msg = "Не удалось добавить комментарий";
        if (Yii::$app->request->isPost) {
            $model->id_quest = (int)$idQuestion;
            $model->id_user = Yii::$app->user->identity->id;
            $model->text = \yii\helpers\Html::encode($text);
            $model->id_parent = (int)$id_parent;
            if($model->save()) $msg = "Комментарий добавлен";
        }

        if(Yii::$app->request->isAjax) {
            return \frontend\components\CommentsWidget::widget([
                'tpl' => 'comments', 
                'model' => $this->getComments($idQuestion), 
                'param' => $idQuestion]);
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

}
