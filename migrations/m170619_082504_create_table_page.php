<?php

use yii\db\Migration;

class m170619_082504_create_table_page extends Migration
{
    public function safeUp()
    {
	    $tableOptions = null;
	    if ($this->db->driverName === 'mysql') {
		    // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
		    $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
	    }
    	$this->createTable('{{%page}}',[
		    'id' => $this->primaryKey(),
		    'slug' => $this->string(255)->notNull()->unique()->comment('Слаг'),
		    'title' => $this->string(255)->notNull()->comment('Название'),
		    'content' => $this->text()->comment('Контент'),
		    'short_content' => $this->text()->comment('Короткий текст'),
		    'image' => $this->string(255)->comment('Картинка'),
		    'category_id' => $this->integer()->unsigned()->comment('Категория'),
		    'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment('Опубликовано'),
		    'created_at' => $this->integer()->unsigned()->notNull(),
		    'updated_at' => $this->integer()->unsigned()->notNull(),
	    ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%page}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170619_082504_create_table_page cannot be reverted.\n";

        return false;
    }
    */
}
