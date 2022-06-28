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
            'path' => $this->string(255),
            'rand' => $this->string(24),
            'thWidth' => $this->smallInteger(),
            'thHeight' => $this->smallInteger(),
            'format' => $this->string(24),
            'thumb' => $this->tinyInteger(),
            'width' => $this->smallInteger(),
            'height' => $this->smallInteger(),
            'image' => $this->tinyInteger(),
            'webp' => $this->tinyInteger(3),
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
