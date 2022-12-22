<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bid_rating}}`.
 */
class m221031_065605_create_bid_rating_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bid_rating}}', [
            'id' => $this->primaryKey(),
            'rating' => $this->float(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bid_rating}}');
    }
}
