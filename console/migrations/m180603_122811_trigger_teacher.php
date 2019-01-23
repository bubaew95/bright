<?php

use yii\db\Migration;
use common\models\User;
use common\components\Constants;

/**
 * Class m180603_122811_trigger_teacher
 */
class m180603_122811_trigger_teacher extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$trigger = "
			CREATE TRIGGER `before_".Constants::ROLE_TEACHER."_add_role` 
			AFTER INSERT ON `".User::tableName()."` 
			FOR EACH ROW 
			BEGIN 
				if (new.isTeacher <> '0') then 
					INSERT into `auth_assignment` (item_name, user_id, created_at) 
					VALUES ('".Constants::ROLE_TEACHER."', new.id, now());
				end if; 
			END; 
		";
		$trigger2 = " 
			CREATE TRIGGER `before_".Constants::ROLE_TEACHER."_update_role` 
			AFTER UPDATE ON `".User::tableName()."` 
			FOR EACH ROW 
			BEGIN 
				if (new.isTeacher <> '0') then 
					INSERT into `auth_assignment` (item_name, user_id, created_at) 
					VALUES ('".Constants::ROLE_TEACHER."', new.id, now());
				else
					DELETE FROM auth_assignment WHERE `user_id` = new.id;
				end if; 
			END;
		";
		try {
			$this->execute($trigger);
			$this->execute($trigger2);
		}catch(Exception $ex) {
			print ($ex);
			return false;
		}
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
		$trigger = "DROP TRIGGER IF EXISTS `before_".Constants::ROLE_TEACHER."_add_role`";
		$trigger2 = "DROP TRIGGER IF EXISTS `before_".Constants::ROLE_TEACHER."_update_role`";
        $this->execute($trigger);
        $this->execute($trigger2); 
    }

}
