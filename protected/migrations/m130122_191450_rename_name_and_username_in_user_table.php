<?php

class m130122_191450_rename_name_and_username_in_user_table extends CDbMigration
{
	public function up()
	{
		$sql = "
			ALTER TABLE `user`
			CHANGE COLUMN `name` `first_name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `created_at`,
			CHANGE COLUMN `username` `last_name`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `first_name`;
		";
		$this->execute($sql);
	}

	public function down()
	{
		return true;
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