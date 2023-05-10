<?php

use yii\db\Migration;

/**
 * Class m230330_125101_create_stm_bid_tbl_tables
 */
class m230330_125101_create_stm_bid_tbl_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stm_bid_tbl}}', [
            'id' => $this->primaryKey(),
            'lvl' => $this->tinyInteger()->notNull()->defaultValue(0),
            'num' => $this->tinyInteger()->notNull()->defaultValue(0),
            'bid' => $this->string(24),
            'img' => $this->string(24),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%stm_bid_tbl}}');
    }
}