<?php

class m130202_172903_add_category_id_to_budgets_table extends CDbMigration
{
	public function up()
	{
		$sql = "
			ALTER TABLE `budget`
			ADD COLUMN `category_id`  int(11) NOT NULL AFTER `name`;
		";
		$this->execute($sql);

		$sql = "
			ALTER TABLE `budget` ADD FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
		";
		$this->execute($sql);
	}

	public function down()
	{
		echo "m130202_172903_add_category_id_to_budgets_table does not support migration down.\n";
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