<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%poll}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%post}}`
 */
class m230510_163216_create_poll_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%poll}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull(),
            'description' => $this->text(),
            'show_result' => $this->tinyInteger()->notNull()->defaultValue(0),
            'save_result' => $this->tinyInteger()->notNull()->defaultValue(0),
            'save_response' => $this->tinyInteger()->notNull()->defaultValue(0),
            'show_only_user_result' => $this->tinyInteger()->notNull()->defaultValue(1),
            'show_grade' => $this->tinyInteger()->notNull()->defaultValue(0),
            'poll_close' => $this->tinyInteger()->notNull()->defaultValue(0),
            'allow_guest' => $this->tinyInteger()->notNull()->defaultValue(0),
            'save_guest_result' => $this->tinyInteger()->notNull()->defaultValue(0),
            'active' => $this->tinyInteger()->notNull()->defaultValue(1),
            'created_at' => $this->integer(11)->notNull(),
        ]);

        // creates index for column `post_id`
        $this->createIndex(
            '{{%idx-poll-post_id}}',
            '{{%poll}}',
            'post_id'
        );

        // add foreign key for table `{{%post}}`
        $this->addForeignKey(
            '{{%fk-poll-post_id}}',
            '{{%poll}}',
            'post_id',
            '{{%post}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%post}}`
        $this->dropForeignKey(
            '{{%fk-poll-post_id}}',
            '{{%poll}}'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            '{{%idx-poll-post_id}}',
            '{{%poll}}'
        );

        $this->dropTable('{{%poll}}');
    }
}
