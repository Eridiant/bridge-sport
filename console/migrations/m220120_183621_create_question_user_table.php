<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%question_user}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%question}}`
 * - `{{%user}}`
 */
class m220120_183621_create_question_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%question_user}}', [
            'id' => $this->primaryKey(),
            'question_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `question_id`
        $this->createIndex(
            '{{%idx-question_user-question_id}}',
            '{{%question_user}}',
            'question_id'
        );

        // add foreign key for table `{{%question}}`
        $this->addForeignKey(
            '{{%fk-question_user-question_id}}',
            '{{%question_user}}',
            'question_id',
            '{{%question}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-question_user-user_id}}',
            '{{%question_user}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-question_user-user_id}}',
            '{{%question_user}}',
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
        // drops foreign key for table `{{%question}}`
        $this->dropForeignKey(
            '{{%fk-question_user-question_id}}',
            '{{%question_user}}'
        );

        // drops index for column `question_id`
        $this->dropIndex(
            '{{%idx-question_user-question_id}}',
            '{{%question_user}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-question_user-user_id}}',
            '{{%question_user}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-question_user-user_id}}',
            '{{%question_user}}'
        );

        $this->dropTable('{{%question_user}}');
    }
}
