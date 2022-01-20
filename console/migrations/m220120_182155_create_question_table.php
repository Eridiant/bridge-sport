<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%question}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%quiz}}`
 */
class m220120_182155_create_question_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%question}}', [
            'id' => $this->primaryKey(),
            'quiz_id' => $this->integer()->notNull(),
            'description' => $this->text(),
        ]);

        // creates index for column `quiz_id`
        $this->createIndex(
            '{{%idx-question-quiz_id}}',
            '{{%question}}',
            'quiz_id'
        );

        // add foreign key for table `{{%quiz}}`
        $this->addForeignKey(
            '{{%fk-question-quiz_id}}',
            '{{%question}}',
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
            '{{%fk-question-quiz_id}}',
            '{{%question}}'
        );

        // drops index for column `quiz_id`
        $this->dropIndex(
            '{{%idx-question-quiz_id}}',
            '{{%question}}'
        );

        $this->dropTable('{{%question}}');
    }
}
