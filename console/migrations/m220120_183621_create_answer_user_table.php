<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%answer_user}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%answer}}`
 * - `{{%user}}`
 */
class m220120_183621_create_answer_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%answer_user}}', [
            'answer_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'value' => $this->text(),
        ]);

        // creates index for column `answer_id`
        $this->createIndex(
            '{{%idx-answer_user-answer_id}}',
            '{{%answer_user}}',
            'answer_id'
        );

        // add foreign key for table `{{%answer}}`
        $this->addForeignKey(
            '{{%fk-answer_user-answer_id}}',
            '{{%answer_user}}',
            'answer_id',
            '{{%answer}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-answer_user-user_id}}',
            '{{%answer_user}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-answer_user-user_id}}',
            '{{%answer_user}}',
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
        // drops foreign key for table `{{%answer}}`
        $this->dropForeignKey(
            '{{%fk-answer_user-answer_id}}',
            '{{%answer_user}}'
        );

        // drops index for column `answer_id`
        $this->dropIndex(
            '{{%idx-answer_user-answer_id}}',
            '{{%answer_user}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-answer_user-user_id}}',
            '{{%answer_user}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-answer_user-user_id}}',
            '{{%answer_user}}'
        );

        $this->dropTable('{{%answer_user}}');
    }
}
