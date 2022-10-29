<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bid}}`.
 */
class m221024_124729_create_bid_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bid}}', [
            'id' => $this->primaryKey(),
            'bid' => $this->string(24),
            'img' => $this->string(24),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bid}}');
    }
}
