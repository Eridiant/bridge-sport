<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%poll_response}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%poll_answer}}`
 * - `{{%user}}`
 */
class m230513_154043_create_poll_response_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%poll_response}}', [
            'id' => $this->primaryKey(),
            'answer_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'date' => $this->integer(11),
        ]);

        // creates index for column `answer_id`
        $this->createIndex(
            '{{%idx-poll_response-answer_id}}',
            '{{%poll_response}}',
            'answer_id'
        );

        // add foreign key for table `{{%poll_answer}}`
        $this->addForeignKey(
            '{{%fk-poll_response-answer_id}}',
            '{{%poll_response}}',
            'answer_id',
            '{{%poll_answer}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-poll_response-user_id}}',
            '{{%poll_response}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-poll_response-user_id}}',
            '{{%poll_response}}',
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
        // drops foreign key for table `{{%poll_answer}}`
        $this->dropForeignKey(
            '{{%fk-poll_response-answer_id}}',
            '{{%poll_response}}'
        );

        // drops index for column `answer_id`
        $this->dropIndex(
            '{{%idx-poll_response-answer_id}}',
            '{{%poll_response}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-poll_response-user_id}}',
            '{{%poll_response}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-poll_response-user_id}}',
            '{{%poll_response}}'
        );

        $this->dropTable('{{%poll_response}}');
    }
}
