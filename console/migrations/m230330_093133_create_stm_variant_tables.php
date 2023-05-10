<?php

use yii\db\Migration;

/**
 * Class m230330_093133_create_stm_variant_tables
 */
class m230330_093133_create_stm_variant_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stm_variant}}', [
            'id' => $this->primaryKey(),
            'variant' => $this->tinyInteger(),
            'variant_desc' => $this->text(),
            'updated_at' => $this->integer(11),
            'created_at' => $this->integer(11)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%stm_variant}}');
    }
}