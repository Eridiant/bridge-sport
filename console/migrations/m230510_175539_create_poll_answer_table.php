<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%poll_answer}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%poll_question}}`
 */
class m230510_175539_create_poll_answer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%poll_answer}}', [
            'id' => $this->primaryKey(),
            'question_id' => $this->integer()->notNull(),
            'text' => $this->text(),
        ]);

        // creates index for column `question_id`
        $this->createIndex(
            '{{%idx-poll_answer-question_id}}',
            '{{%poll_answer}}',
            'question_id'
        );

        // add foreign key for table `{{%poll_question}}`
        $this->addForeignKey(
            '{{%fk-poll_answer-question_id}}',
            '{{%poll_answer}}',
            'question_id',
            '{{%poll_question}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%poll_question}}`
        $this->dropForeignKey(
            '{{%fk-poll_answer-question_id}}',
            '{{%poll_answer}}'
        );

        // drops index for column `question_id`
        $this->dropIndex(
            '{{%idx-poll_answer-question_id}}',
            '{{%poll_answer}}'
        );

        $this->dropTable('{{%poll_answer}}');
    }
}
