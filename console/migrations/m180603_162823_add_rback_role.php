<?php

use yii\db\Migration;

/**
 * Class m180603_162823_add_rback_role
 */
class m180603_162823_add_rback_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        try {
            $auth = Yii::$app->authManager;
            $auth->removeAll(); //На всякий случай удаляем старые данные из БД...
            // Создадим роли админа и редактора новостей
            $admin = $auth->createRole('admin');
            $teacher = $auth->createRole('teacher');
            // запишем их в БД
            $auth->add($admin);
            $auth->add($teacher);
            // Создаем разрешения. Например, просмотр админки isEnterAdminka и редактирование новости updateNews
            $isEnterAdminka = $auth->createPermission('isEnterAdminka');
            $isEnterAdminka->description = 'Доступ в админку';
            // Запишем эти разрешения в БД
            $auth->add($isEnterAdminka);
            // админ наследует роль редактора новостей. Он же админ, должен уметь всё! :D
            $auth->addChild($admin, $teacher);
            //Учитель наследуется от isEnterAdminka т.е. должен иметь доступ в админку!
            $auth->addChild($teacher, $isEnterAdminka);
            // Еще админ имеет собственное разрешение - «Просмотр админки»
            $auth->addChild($admin, $isEnterAdminka);
            // Назначаем роль admin пользователю с ID 1
            $auth->assign($admin, 1);
        } catch (Exception $ex) {
            print($ex->getMessage());
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
