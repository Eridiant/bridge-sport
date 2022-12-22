<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%youtube}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%image}}`
 */
class m220102_183305_create_youtube_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%youtube}}', [
            'id' => $this->primaryKey(),
            'image_id' => $this->integer(),
            'youtube' => $this->text(),
            'key' => $this->string(127),
            'hide' => $this->tinyInteger(),
        ]);

        // creates index for column `image_id`
        $this->createIndex(
            '{{%idx-youtube-image_id}}',
            '{{%youtube}}',
            'image_id'
        );

        // add foreign key for table `{{%image}}`
        $this->addForeignKey(
            '{{%fk-youtube-image_id}}',
            '{{%youtube}}',
            'image_id',
            '{{%image}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%image}}`
        $this->dropForeignKey(
            '{{%fk-youtube-image_id}}',
            '{{%youtube}}'
        );

        // drops index for column `image_id`
        $this->dropIndex(
            '{{%idx-youtube-image_id}}',
            '{{%youtube}}'
        );

        $this->dropTable('{{%youtube}}');
    }
}
