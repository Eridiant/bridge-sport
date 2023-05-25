<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%poll_user}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%poll}}`
 * - `{{%user}}`
 */
class m230519_171054_create_junction_table_for_poll_and_user_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%poll_user}}', [
            'poll_id' => $this->integer(),
            'user_id' => $this->integer(),
            'score' => $this->smallInteger(),
            'created_at' => $this->integer(11)->notNull(),
            'PRIMARY KEY(poll_id, user_id)',
        ]);

        // creates index for column `poll_id`
        $this->createIndex(
            '{{%idx-poll_user-poll_id}}',
            '{{%poll_user}}',
            'poll_id'
        );

        // add foreign key for table `{{%poll}}`
        $this->addForeignKey(
            '{{%fk-poll_user-poll_id}}',
            '{{%poll_user}}',
            'poll_id',
            '{{%poll}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-poll_user-user_id}}',
            '{{%poll_user}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-poll_user-user_id}}',
            '{{%poll_user}}',
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
        // drops foreign key for table `{{%poll}}`
        $this->dropForeignKey(
            '{{%fk-poll_user-poll_id}}',
            '{{%poll_user}}'
        );

        // drops index for column `poll_id`
        $this->dropIndex(
            '{{%idx-poll_user-poll_id}}',
            '{{%poll_user}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-poll_user-user_id}}',
            '{{%poll_user}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-poll_user-user_id}}',
            '{{%poll_user}}'
        );

        $this->dropTable('{{%poll_user}}');
    }
}
