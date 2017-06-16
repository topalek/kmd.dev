<?php

use yii\db\Migration;

class m170616_074659_init extends Migration
{

	public function safeUp()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			// http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
			$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}
		$this->createTable('{{%user}}', [
			'id' => $this->primaryKey(),
			'username' => $this->string()->notNull()->unique(),
			'auth_key' => $this->string(32)->notNull(),
			'password_hash' => $this->string()->notNull(),
			'password_reset_token' => $this->string()->unique(),
			'email' => $this->string()->notNull()->unique(),
			'status' => $this->smallInteger()->notNull()->defaultValue(10),
			'created_at' => $this->integer()->unsigned()->notNull(),
			'updated_at' => $this->integer()->unsigned()->notNull(),
		], $tableOptions);
	}
	public function safeDown()
	{
		$this->dropTable('{{%user}}');
	}

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170616_074659_init cannot be reverted.\n";

        return false;
    }
    */
}
