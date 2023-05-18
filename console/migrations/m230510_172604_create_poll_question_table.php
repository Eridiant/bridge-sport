<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%poll_question}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%poll}}`
 */
class m230510_172604_create_poll_question_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%poll_question}}', [
            'id' => $this->primaryKey(),
            'poll_id' => $this->integer()->notNull(),
            'type' => $this->tinyInteger(),
            'text' => $this->text(),
            'comment' => $this->text(),
        ]);

        // creates index for column `poll_id`
        $this->createIndex(
            '{{%idx-poll_question-poll_id}}',
            '{{%poll_question}}',
            'poll_id'
        );

        // add foreign key for table `{{%poll}}`
        $this->addForeignKey(
            '{{%fk-poll_question-poll_id}}',
            '{{%poll_question}}',
            'poll_id',
            '{{%poll}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%poll}}`
        $this->dropForeignKey(
            '{{%fk-poll_question-poll_id}}',
            '{{%poll_question}}'
        );

        // drops index for column `poll_id`
        $this->dropIndex(
            '{{%idx-poll_question-poll_id}}',
            '{{%poll_question}}'
        );

        $this->dropTable('{{%poll_question}}');
    }
}
