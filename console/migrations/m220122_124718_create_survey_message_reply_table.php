<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%survey_message_reply}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%survey_message}}`
 * - `{{%user}}`
 */
class m220122_124718_create_survey_message_reply_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%survey_message_reply}}', [
            'id' => $this->primaryKey(),
            'survey_message_id' => $this->integer()->notNull(),
            'answer_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'message' => $this->text(),
            'show' => $this->tinyInteger(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11),
            'deleted_at' => $this->integer(11),
        ]);

        // creates index for column `survey_message_id`
        $this->createIndex(
            '{{%idx-survey_message_reply-survey_message_id}}',
            '{{%survey_message_reply}}',
            'survey_message_id'
        );

        // add foreign key for table `{{%survey_message}}`
        $this->addForeignKey(
            '{{%fk-survey_message_reply-survey_message_id}}',
            '{{%survey_message_reply}}',
            'survey_message_id',
            '{{%survey_message}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-survey_message_reply-user_id}}',
            '{{%survey_message_reply}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-survey_message_reply-user_id}}',
            '{{%survey_message_reply}}',
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
        // drops foreign key for table `{{%survey_message}}`
        $this->dropForeignKey(
            '{{%fk-survey_message_reply-survey_message_id}}',
            '{{%survey_message_reply}}'
        );

        // drops index for column `survey_message_id`
        $this->dropIndex(
            '{{%idx-survey_message_reply-survey_message_id}}',
            '{{%survey_message_reply}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-survey_message_reply-user_id}}',
            '{{%survey_message_reply}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-survey_message_reply-user_id}}',
            '{{%survey_message_reply}}'
        );

        $this->dropTable('{{%survey_message_reply}}');
    }
}
