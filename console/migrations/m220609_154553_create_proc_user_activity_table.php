<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%proc_user_activity}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m220609_154553_create_proc_user_activity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%proc_user_activity}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'url' => $this->string(255),
            'status' => $this->smallInteger(),
            'ref' => $this->string(255),
            'lang' => $this->string(12),
            'device' => $this->string(255),
            'created_at' => $this->integer()->notNull(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-proc_user_activity-user_id}}',
            '{{%proc_user_activity}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-proc_user_activity-user_id}}',
            '{{%proc_user_activity}}',
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
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-proc_user_activity-user_id}}',
            '{{%proc_user_activity}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-proc_user_activity-user_id}}',
            '{{%proc_user_activity}}'
        );

        $this->dropTable('{{%proc_user_activity}}');
    }
}
