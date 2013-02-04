<?php

class m130202_154151_category_created_at_default_value extends CDbMigration
{
	public function up()
	{
		$sql = "
			ALTER TABLE `category`
			MODIFY COLUMN `created_at`  timestamp NULL DEFAULT CURRENT_TIMESTAMP AFTER `id`;
		";
		$this->execute($sql);
	}

	public function down()
	{
		echo "m130202_154151_category_created_at_default_value does not support migration down.\n";
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