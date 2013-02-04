<?php

class m130202_162004_add_budget_category_foreign_keys extends CDbMigration
{
	public function up()
	{
		$sql = "ALTER TABLE `budget_category` ENGINE=InnoDB; ";
		$this->execute($sql);

		$sql = "ALTER TABLE `budget` ENGINE=InnoDB; ";
		$this->execute($sql);

		$sql = "ALTER TABLE `budget_category` ADD FOREIGN KEY (`budget_id`) REFERENCES `budget` (`id`); ";
		$this->execute($sql);

		$sql = "ALTER TABLE `budget_category` ADD FOREIGN KEY (`category_id`) REFERENCES `category` (`id`); ";
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