<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%taxonomy}}`.
 */
class m220111_193418_create_taxonomy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%taxonomy}}', [
            'id' => $this->primaryKey(11),
            'label' => $this->string(255),
            'singular' => $this->string(255),
            'attr_key' => $this->string(255),
            'value' => $this->smallInteger(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%taxonomy}}');
    }
}
