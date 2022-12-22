<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%proc_user_ip}}`.
 */
class m220523_083505_create_proc_user_ip_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%proc_user_ip}}', [
            'id' => $this->primaryKey(),
            'ip' => $this->binary(16)->notNull(),
            'ref' => $this->string(255),
            'code' => $this->string(10),
            'region' => $this->string(128),
            'country' => $this->string(64),
            'city' => $this->string(64),
            'created_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%proc_user_ip}}');
    }
}
