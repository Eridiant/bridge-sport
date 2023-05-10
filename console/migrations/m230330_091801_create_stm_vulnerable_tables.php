<?php

use yii\db\Migration;

/**
 * Class m230330_091801_create_stm_vulnerable_tables
 */
class m230330_091801_create_stm_vulnerable_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stm_vulnerable}}', [
            'id' => $this->primaryKey(),
            'vulnerable' => $this->tinyInteger(),
            'vulnerable_desc' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%stm_vulnerable}}');
    }
}