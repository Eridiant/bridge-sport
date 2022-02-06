<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%answer}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%quiz}}`
 */
class m220120_182155_create_answer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%answer}}', [
            'id' => $this->primaryKey(),
            'quiz_id' => $this->integer()->notNull(),
            'answer_id' => $this->integer(),
            'description' => $this->text(),
        ]);

        // creates index for column `quiz_id`
        $this->createIndex(
            '{{%idx-answer-quiz_id}}',
            '{{%answer}}',
            'quiz_id'
        );

        // add foreign key for table `{{%quiz}}`
        $this->addForeignKey(
            '{{%fk-answer-quiz_id}}',
            '{{%answer}}',
            'quiz_id',
            '{{%quiz}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%quiz}}`
        $this->dropForeignKey(
            '{{%fk-answer-quiz_id}}',
            '{{%answer}}'
        );

        // drops index for column `quiz_id`
        $this->dropIndex(
            '{{%idx-answer-quiz_id}}',
            '{{%answer}}'
        );

        $this->dropTable('{{%answer}}');
    }
}
