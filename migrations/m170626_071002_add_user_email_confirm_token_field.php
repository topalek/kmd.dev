<?php

use yii\db\Migration;

class m170626_071002_add_user_email_confirm_token_field extends Migration
{
    public function safeUp()
    {
		$this->addColumn('{{%user}}', 'email_confirm_token', $this->string()->unique()->after('email'));
    }

    public function safeDown()
    {
	    $this->dropColumn('{{%user}}', 'email_confirm_token');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170626_071002_add_user_email_confirm_token_field cannot be reverted.\n";

        return false;
    }
    */
}
