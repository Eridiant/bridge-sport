<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%poll_result}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%poll_answer}}`
 */
class m230512_184435_create_poll_result_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%poll_result}}', [
            'id' => $this->primaryKey(),
            'answer_id' => $this->integer()->notNull(),
            'result_count' => $this->smallInteger(),
            'date' => $this->integer(11),
        ]);

        // creates index for column `answer_id`
        $this->createIndex(
            '{{%idx-poll_result-answer_id}}',
            '{{%poll_result}}',
            'answer_id'
        );

        // add foreign key for table `{{%poll_answer}}`
        $this->addForeignKey(
            '{{%fk-poll_result-answer_id}}',
            '{{%poll_result}}',
            'answer_id',
            '{{%poll_answer}}',
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
            '{{%fk-poll_result-answer_id}}',
            '{{%poll_result}}'
        );

        // drops index for column `answer_id`
        $this->dropIndex(
            '{{%idx-poll_result-answer_id}}',
            '{{%poll_result}}'
        );

        $this->dropTable('{{%poll_result}}');
    }
}
