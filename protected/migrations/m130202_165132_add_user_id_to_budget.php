<?php

class m130202_165132_add_user_id_to_budget extends CDbMigration
{
	public function up()
	{
		$sql = "
			ALTER TABLE `budget`
			ADD COLUMN `user_id`  int(11) NOT NULL AFTER `created_at`;
		";
		$this->execute($sql);

		$sql = "ALTER TABLE `budget` ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`); ";
		$this->execute($sql);
	}

	public function down()
	{
		echo "m130202_165132_add_user_id_to_budget does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}