<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%error_log}}`.
 */
class m220523_115443_create_error_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%error_log}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64),
            'error' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%error_log}}');
    }
}
