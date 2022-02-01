<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%survey_message}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%survey}}`
 * - `{{%user}}`
 */
class m220122_121058_create_survey_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%survey_message}}', [
            'id' => $this->primaryKey(),
            'survey_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'message' => $this->text(),
            'show' => $this->tinyInteger(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11),
            'deleted_at' => $this->integer(11),
        ]);

        // creates index for column `survey_id`
        $this->createIndex(
            '{{%idx-survey_message-survey_id}}',
            '{{%survey_message}}',
            'survey_id'
        );

        // add foreign key for table `{{%survey}}`
        $this->addForeignKey(
            '{{%fk-survey_message-survey_id}}',
            '{{%survey_message}}',
            'survey_id',
            '{{%survey}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-survey_message-user_id}}',
            '{{%survey_message}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-survey_message-user_id}}',
            '{{%survey_message}}',
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
        // drops foreign key for table `{{%survey}}`
        $this->dropForeignKey(
            '{{%fk-survey_message-survey_id}}',
            '{{%survey_message}}'
        );

        // drops index for column `survey_id`
        $this->dropIndex(
            '{{%idx-survey_message-survey_id}}',
            '{{%survey_message}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-survey_message-user_id}}',
            '{{%survey_message}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-survey_message-user_id}}',
            '{{%survey_message}}'
        );

        $this->dropTable('{{%survey_message}}');
    }
}
