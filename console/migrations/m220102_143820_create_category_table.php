<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m220102_143820_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->smallInteger()->notNull()->defaultValue(0),
            'name' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull(),
            'img' => $this->string(255),
            'keywords' => $this->string(255),
            'description' => $this->text(),
            'active' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'deleted_at' => $this->integer(11),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category}}');
    }
}
