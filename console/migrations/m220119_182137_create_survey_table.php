<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%survey}}`.
 */
class m220119_182137_create_survey_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%survey}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull(),
            'img' => $this->string(255),
            'keywords' => $this->string(255),
            'preview' => $this->text(),
            'description' => $this->text(),
            'type' => $this->tinyInteger(),
            'access' => $this->tinyInteger(),
            'active' => $this->tinyInteger(),
            'author_id' => $this->integer(11),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11),
            'deleted_at' => $this->integer(11),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%survey}}');
    }
}
