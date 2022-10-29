<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%variant}}`.
 */
class m221023_065440_create_variant_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%variant}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%variant}}');
    }
}
