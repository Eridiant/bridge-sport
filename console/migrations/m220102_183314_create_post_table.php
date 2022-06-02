<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%image}}`
 * - `{{%iframe}}`
 * - `{{%category}}`
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
            'parent_id' => $this->integer(11),
            'name' => $this->string(255)->notNull(),
            'url' => $this->text(),
            'slug' => $this->string(255)->notNull(),
            'preview' => $this->text(),
            'text' => $this->text(),
            'image_id' => $this->integer(11),
            'dial' => $this->string(255),
            'iframe_id' => $this->integer(11),
            'youtube_id' => $this->integer(11),
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
            '{{%idx-post-url}}',
            '{{%post}}',
            'url'
        );
        $this->createIndex(
            '{{%idx-post-slug}}',
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

        // creates index for column `image_id`
        $this->createIndex(
            '{{%idx-post-image_id}}',
            '{{%post}}',
            'image_id'
        );

        // add foreign key for table `{{%image}}`
        $this->addForeignKey(
            '{{%fk-post-image_id}}',
            '{{%post}}',
            'image_id',
            '{{%image}}',
            'id',
            'CASCADE'
        );

        // creates index for column `iframe_id`
        $this->createIndex(
            '{{%idx-post-iframe_id}}',
            '{{%post}}',
            'iframe_id'
        );

        // add foreign key for table `{{%iframe}}`
        $this->addForeignKey(
            '{{%fk-post-iframe_id}}',
            '{{%post}}',
            'iframe_id',
            '{{%iframe}}',
            'id',
            'CASCADE'
        );

        // creates index for column `youtube_id`
        $this->createIndex(
            '{{%idx-post-youtube_id}}',
            '{{%post}}',
            'youtube_id'
        );

        // add foreign key for table `{{%youtube}}`
        $this->addForeignKey(
            '{{%fk-post-youtube_id}}',
            '{{%post}}',
            'youtube_id',
            '{{%youtube}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%youtube}}`
        $this->dropForeignKey(
            '{{%fk-post-youtube_id}}',
            '{{%post}}'
        );

        // drops index for column `youtube_id`
        $this->dropIndex(
            '{{%idx-post-youtube_id}}',
            '{{%post}}'
        );

        // drops foreign key for table `{{%image}}`
        $this->dropForeignKey(
            '{{%fk-post-image_id}}',
            '{{%post}}'
        );

        // drops index for column `image_id`
        $this->dropIndex(
            '{{%idx-post-image_id}}',
            '{{%post}}'
        );

        // drops foreign key for table `{{%iframe}}`
        $this->dropForeignKey(
            '{{%fk-post-iframe_id}}',
            '{{%post}}'
        );

        // drops index for column `iframe_id`
        $this->dropIndex(
            '{{%idx-post-iframe_id}}',
            '{{%post}}'
        );

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
            '{{%idx-post-slug}}',
            '{{%post}}'
        );

        $this->dropIndex(
            '{{%idx-post-url}}',
            '{{%post}}'
        );

        $this->dropTable('{{%post}}');
    }
}
