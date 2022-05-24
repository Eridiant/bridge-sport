<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%proc_user_ip}}`.
 */
class m220524_114009_create_proc_user_ip_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%proc_user_ip}}', [
            'id' => $this->primaryKey(),
            'ip' => $this->string(39)->notNull(),
            'ref' => $this->string(255),
            'code' => $this->string(10),
            'region' => $this->string(128),
            'country' => $this->string(64),
            'city' => $this->string(64),
            'created_at' => $this->integer()->notNull(),
        ]);

        // creates index for column `ip`
        $this->createIndex(
            '{{%idx-proc-user-ip-ip}}',
            '{{%proc_user_ip}}',
            'ip'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops index for column `ip`
        $this->dropIndex(
            '{{%idx-proc-user-ip-ip}}',
            '{{%proc_user_ip}}',
            'ip'
        );

        $this->dropTable('{{%proc_user_ip}}');
    }
}
