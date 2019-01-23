<?php

use yii\db\Migration;
use common\models\DzhCourse;

/**
 * Class m180812_144527_trigger_join_course
 */
class m180812_144527_trigger_join_course extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $trigger = "
			CREATE TRIGGER `before_insert_course` 
			AFTER INSERT ON `".DzhCourse::tableName()."` 
			FOR EACH ROW 
			BEGIN 
                INSERT into `".\common\models\DzhJoincourse::tableName()."` (id_user, id_course, price, total_price, actived) 
                VALUES (new.id_user, new.id, 0, 0, '1');
			END; 
		";
        $this->execute($trigger);

        $this->insert(\common\models\DzhJoincourse::tableName(), [
            'id_user' => 1,
            'id_course' => 8,
            'price' => 0,
            'total_price' => 0,
            'actived' => '1'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $trigger = "DROP TRIGGER IF EXISTS `before_insert_course`";
        $this->execute($trigger);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180812_144527_trigger_join_course cannot be reverted.\n";

        return false;
    }
    */
}
