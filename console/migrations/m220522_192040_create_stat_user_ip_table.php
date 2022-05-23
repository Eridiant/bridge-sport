<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stat_user_ip}}`.
 */
class m220522_192040_create_stat_user_ip_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stat_user_ip}}', [
            'id' => $this->primaryKey(),
            'ip' => $this->integer(10)->unsigned()->notNull(),
            'url' => $this->string(255),
            'ref' => $this->string(255),
            'lang' => $this->string(12),
            'lang_all' => $this->string(255),
            'device' => $this->string(255),
            'created_at' => $this->integer()->notNull(),
        ]);

        // creates index for column `ip`
        $this->createIndex(
            '{{%idx-stat-user-ip-ip}}',
            '{{%user_ip}}',
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
            '{{%idx-stat-user-ip-ip}}',
            '{{%user_ip}}',
            'ip'
        );

        $this->dropTable('{{%stat_user_ip}}');
    }
}
