<?php

use yii\db\Migration;

/**
 * Handles the creation of table `image`.
 */
class m170620_100430_create_image_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%image}}', [
	        'id' => $this->primaryKey(),
	        'post_id' => $this->integer()->notNull(),
	        'file' => $this->string()->notNull(),
	        'sort' => $this->integer()->notNull(),
        ]);
	    $this->createIndex('{{%idx-image-post_id}}', '{{%image}}', 'post_id');
	    $this->addForeignKey('{{%fk-image-post_id}}', '{{%image}}', 'post_id', '{{%image}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%image}}');
    }
}
