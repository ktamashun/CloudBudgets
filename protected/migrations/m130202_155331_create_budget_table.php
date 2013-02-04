<?php

class m130202_155331_create_budget_table extends CDbMigration
{
	public function up()
	{
		$sql = "
			CREATE TABLE `budget` (
				`id`  int(11) NOT NULL AUTO_INCREMENT ,
				`created_at`  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ,
				`from_date`  date NOT NULL ,
				`to_date`  date NULL ,
				`name`  varchar(255) NOT NULL ,
				`limit`  int(11) NOT NULL ,
				`active`  tinyint(2) NOT NULL DEFAULT 1 ,
				PRIMARY KEY (`id`)
			);
		";
		$this->execute($sql);
	}

	public function down()
	{
		echo "m130202_155331_create_budget_table does not support migration down.\n";
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