<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%message_reply}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%message}}`
 */
class m220911_140156_create_message_reply_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%message_reply}}', [
            'id' => $this->primaryKey(),
            'message_id' => $this->integer()->notNull(),
            'answer_id' => $this->integer(),
            'answer_user' => $this->integer(11),
            'user_id' => $this->integer()->notNull(),
            'message' => $this->text(),
            'history' => $this->text(),
            'show' => $this->tinyInteger(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11),
            'deleted_at' => $this->integer(11),
        ]);

        // creates index for column `message_id`
        $this->createIndex(
            '{{%idx-message_reply-message_id}}',
            '{{%message_reply}}',
            'message_id'
        );

        // add foreign key for table `{{%message}}`
        $this->addForeignKey(
            '{{%fk-message_reply-message_id}}',
            '{{%message_reply}}',
            'message_id',
            '{{%message}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-message_reply-user_id}}',
            '{{%message_reply}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-message_reply-user_id}}',
            '{{%message_reply}}',
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

        // drops foreign key for table `{{%message}}`
        $this->dropForeignKey(
            '{{%fk-message_reply-user_id}}',
            '{{%message_reply}}'
        );

        // drops index for column `message_id`
        $this->dropIndex(
            '{{%idx-message_reply-user_id}}',
            '{{%message_reply}}'
        );

        // drops foreign key for table `{{%message_reply}}`
        $this->dropForeignKey(
            '{{%fk-message_reply-message_id}}',
            '{{%message_reply}}'
        );

        // drops index for column `message_reply`
        $this->dropIndex(
            '{{%idx-message_reply-message_id}}',
            '{{%message_reply}}'
        );

        $this->dropTable('{{%message_reply}}');
    }
}
