<?php

use yii\db\Migration;

class m170620_135226_add_post_main_image_field extends Migration
{
    public function safeUp()
    {
	    $this->addColumn('{{%post}}', 'main_photo_id', $this->integer());
	    $this->createIndex('{{%idx-post-main_photo_id}}', '{{%post}}', 'main_photo_id');
	    $this->addForeignKey('{{%fk-post-main_photo_id}}', '{{%post}}', 'main_photo_id', '{{%image}}', 'id', 'SET NULL', 'RESTRICT');
    }

    public function safeDown()
    {
       $this->dropForeignKey('{{%fk-post-main_photo_id}}', '{{%post}}');
       $this->dropColumn('{{%post}}', 'main_photo_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170620_135226_add_post_main_image_field cannot be reverted.\n";

        return false;
    }
    */
}
