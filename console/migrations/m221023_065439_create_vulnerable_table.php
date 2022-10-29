<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vulnerable}}`.
 */
class m221023_065439_create_vulnerable_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vulnerable}}', [
            'id' => $this->primaryKey(),
            'vulnerable' => $this->tinyInteger(),
            'description' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vulnerable}}');
    }
}
