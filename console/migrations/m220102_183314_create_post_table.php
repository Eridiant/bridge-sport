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
            'parent_id' => $this->integer(4),
            'name' => $this->string(255)->notNull(),
            'url' => $this->text(),
            'slug' => $this->string(255)->notNull(),
            'preview' => $this->text(),
            'text' => $this->text(),
            'img' => $this->string(255),
            'dial' => $this->string(255),
            'iframe' => $this->text(),
            'indexing' => $this->tinyInteger()->notNull()->defaultValue(0),
            'title' => $this->string(255),
            'description' => $this->text(),
            'keywords' => $this->string(255),
            'status' => $this->tinyInteger()->notNull()->defaultValue(0),
            'author_id' => $this->integer(11),
            'published_at' => $this->integer(11),
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

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-post-category_id}}',
            '{{%post}}',
            'category_id'
        );

        // add foreign key for table `{{%category}}`
        $this->addForeignKey(
            '{{%fk-post-category_id}}',
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

        // drops foreign key for table `{{%category}}`
        $this->dropForeignKey(
            '{{%fk-post-category_id}}',
            '{{%post}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-post-category_id}}',
            '{{%post}}'
        );

        $this->dropIndex(
            '{{%idx-post-url}}',
            '{{%post}}'
        );

        $this->dropIndex(
            '{{%idx-post-slug}}',
            '{{%post}}'
        );

        $this->dropTable('{{%post}}');
    }
}
