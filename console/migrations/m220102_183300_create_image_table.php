<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%image}}`.
 */
class m220102_183300_create_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%image}}', [
            'id' => $this->primaryKey(),
            'alt' => $this->string(255),
            'url' => $this->string(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%image}}');
    }
}
