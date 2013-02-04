<?php

class m130202_161657_create_budget_category_table extends CDbMigration
{
	public function up()
	{
		$sql = "
			CREATE TABLE `budget_category` (
				`id`  int(11) NOT NULL AUTO_INCREMENT ,
				`budget_id`  int(11) NOT NULL ,
				`category_id`  int(11) NOT NULL ,
				PRIMARY KEY (`id`)
			);
		";
		$this->execute($sql);
	}

	public function down()
	{
		echo "m130202_161657_create_budget_category_table does not support migration down.\n";
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