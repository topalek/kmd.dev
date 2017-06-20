<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post`.
 */
class m170619_115418_create_post_table extends Migration
{
    /**
     * @inheritdoc
     */

    public function up()
    {
	    $tableOptions = null;
	    if ($this->db->driverName === 'mysql') {
		    $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
	    }
        $this->createTable('{{%post}}', [
	        'id' => $this->primaryKey(),
	        'slug' => $this->string(255)->notNull()->unique()->comment('Слаг'),
	        'title' => $this->string(255)->notNull()->comment('Название'),
	        'content' => $this->text()->comment('Контент'),
	        'short_content' => $this->text()->comment('Короткий текст'),
	        'type' => $this->string(255)->comment('Тип записи'),
	        'image' => $this->string(255)->comment('Картинка'),
	        'category_id' => $this->integer()->unsigned()->comment('Категория'),
	        'status' => $this->smallInteger()->notNull()->defaultValue(1)->comment('Опубликовано'),
	        'created_at' => $this->integer()->unsigned()->notNull(),
	        'updated_at' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('post');
    }
}
