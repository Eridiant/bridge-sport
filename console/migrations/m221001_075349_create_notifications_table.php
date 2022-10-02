<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%notifications}}`.
 */
class m221001_075349_create_notifications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%notifications}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'url' => $this->text(),
            'message_id' => $this->integer(11),
            'parent_id' => $this->integer(11),
            'created_at' => $this->integer(11)->notNull(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-notifications-user_id}}',
            '{{%notifications}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-notifications-user_id}}',
            '{{%notifications}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-notifications-user_id}}',
            '{{%notifications}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-notifications-user_id}}',
            '{{%notifications}}'
        );

        $this->dropTable('{{%notifications}}');
    }
}
