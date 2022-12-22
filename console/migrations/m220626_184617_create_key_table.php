<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%key}}`.
 */
class m220626_184617_create_key_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%key}}', [
            'id' => $this->primaryKey(),
            'key' => $this->string(255),
            'value' => $this->string(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%key}}');
    }
}
