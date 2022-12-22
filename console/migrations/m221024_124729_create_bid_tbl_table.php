<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bid}}`.
 */
class m221024_124729_create_bid_tbl_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bid_tbl}}', [
            'id' => $this->primaryKey(),
            'lvl' => $this->tinyInteger()->notNull()->defaultValue(0),
            'bid' => $this->string(24),
            'img' => $this->string(24),
            'type' => $this->tinyInteger()->notNull()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bid_tbl}}');
    }
}
