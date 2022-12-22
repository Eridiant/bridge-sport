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
            'ip6' => $this->string(39)->notNull(),
            'status' => $this->smallInteger(),
            'url' => $this->string(255),
            'ref' => $this->string(255),
            'lang_choose' => $this->string(12),
            'lang_all' => $this->string(128),
            'device' => $this->string(255),
            'created_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%stat_user_ip}}');
    }
}
