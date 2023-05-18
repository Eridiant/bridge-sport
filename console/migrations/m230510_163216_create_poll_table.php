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
            'type' => $this->tinyInteger(),
            'show_result' => $this->tinyInteger(),
            'grade' => $this->tinyInteger(),
            'description' => $this->text(),
            'active' => $this->tinyInteger(),
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
