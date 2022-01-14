<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 */
class m220102_183314_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(4)->notNull(),
            'name' => $this->string(255)->notNull(),
            'url' => $this->text(),
            'slug' => $this->string(255)->notNull(),
            'preview' => $this->text(),
            'description' => $this->text(),
            'img' => $this->string(255),
            'dial' => $this->string(255),
            'indexing' => $this->tinyInteger()->notNull()->defaultValue(0),
            'keywords' => $this->string(255),
            'active' => $this->tinyInteger()->notNull()->defaultValue(1),
            'author_id' => $this->integer(11),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11),
            'deleted_at' => $this->integer(11),
        ]);
        $this->createIndex(
            'idx-post-url',
            '{{%post}}',
            'url'
        );
        $this->createIndex(
            'idx-post-slug',
            '{{%post}}',
            'slug'
        );
        $this->addForeignKey(
            'fk-category-post',
            '{{%post}}',
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-category-post',
            '{{%post}}',
        );
        $this->dropTable('{{%post}}');
    }
}
