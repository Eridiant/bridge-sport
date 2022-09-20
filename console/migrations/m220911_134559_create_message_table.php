<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%message}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%post}}`
 */
class m220911_134559_create_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%message}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'message' => $this->text(),
            'history' => $this->text(),
            'show' => $this->tinyInteger(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11),
            'deleted_at' => $this->integer(11),
        ]);

        // creates index for column `post_id`
        $this->createIndex(
            '{{%idx-message-post_id}}',
            '{{%message}}',
            'post_id'
        );

        // add foreign key for table `{{%post}}`
        $this->addForeignKey(
            '{{%fk-message-post_id}}',
            '{{%message}}',
            'post_id',
            '{{%post}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-message-user_id}}',
            '{{%message}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-message-user_id}}',
            '{{%message}}',
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
            '{{%fk-message-user_id}}',
            '{{%message}}'
        );

        // drops index for column `survey_id`
        $this->dropIndex(
            '{{%idx-message-user_id}}',
            '{{%message}}'
        );

        // drops foreign key for table `{{%post}}`
        $this->dropForeignKey(
            '{{%fk-message-post_id}}',
            '{{%message}}'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            '{{%idx-message-post_id}}',
            '{{%message}}'
        );

        $this->dropTable('{{%message}}');
    }
}
