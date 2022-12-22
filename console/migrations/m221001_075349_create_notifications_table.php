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
            'user_id' => $this->integer(11),
            'post_id' => $this->integer(11),
            'respondent_id' => $this->integer(11),
            'reply_id' => $this->integer(11),
            'title' => $this->string(255),
            'text' => $this->text(),
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

        // creates index for column `message_id`
        // $this->createIndex(
        //     '{{%idx-notifications-message_id}}',
        //     '{{%notifications}}',
        //     'message_id'
        // );

        // add foreign key for table `{{%message}}`
        // $this->addForeignKey(
        //     '{{%fk-notifications-message_id}}',
        //     '{{%notifications}}',
        //     'message_id',
        //     '{{%message}}',
        //     'id',
        //     'CASCADE'
        // );

        // creates index for column `reply_id`
        $this->createIndex(
            '{{%idx-notifications-reply_id}}',
            '{{%notifications}}',
            'reply_id'
        );

        // add foreign key for table `{{%reply}}`
        $this->addForeignKey(
            '{{%fk-notifications-reply_id}}',
            '{{%notifications}}',
            'reply_id',
            '{{%message_reply}}',
            'id',
            'CASCADE'
        );

        // creates index for column `post_id`
        $this->createIndex(
            '{{%idx-notifications-post_id}}',
            '{{%notifications}}',
            'post_id'
        );

        // add foreign key for table `{{%post}}`
        $this->addForeignKey(
            '{{%fk-notifications-post_id}}',
            '{{%notifications}}',
            'post_id',
            '{{%post}}',
            'id',
            'CASCADE'
        );

        // creates index for column `respondent_id`
        $this->createIndex(
            '{{%idx-notifications-respondent_id}}',
            '{{%notifications}}',
            'respondent_id'
        );

        // add foreign key for table `{{%respondent}}`
        $this->addForeignKey(
            '{{%fk-notifications-respondent_id}}',
            '{{%notifications}}',
            'respondent_id',
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
        // drops foreign key for table `{{%respondent}}`
        $this->dropForeignKey(
            '{{%fk-notifications-respondent_id}}',
            '{{%notifications}}'
        );

        // drops index for column `respondent_id`
        $this->dropIndex(
            '{{%idx-notifications-respondent_id}}',
            '{{%notifications}}'
        );

        // drops foreign key for table `{{%post}}`
        $this->dropForeignKey(
            '{{%fk-notifications-post_id}}',
            '{{%notifications}}'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            '{{%idx-notifications-post_id}}',
            '{{%notifications}}'
        );

        // drops foreign key for table `{{%reply}}`
        $this->dropForeignKey(
            '{{%fk-notifications-reply_id}}',
            '{{%notifications}}'
        );

        // drops index for column `reply_id`
        $this->dropIndex(
            '{{%idx-notifications-reply_id}}',
            '{{%notifications}}'
        );

        // drops foreign key for table `{{%message}}`
        // $this->dropForeignKey(
        //     '{{%fk-notifications-message_id}}',
        //     '{{%notifications}}'
        // );

        // drops index for column `message_id`
        // $this->dropIndex(
        //     '{{%idx-notifications-message_id}}',
        //     '{{%notifications}}'
        // );

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
