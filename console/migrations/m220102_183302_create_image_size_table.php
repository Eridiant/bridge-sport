<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%image_size}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%image}}`
 */
class m220102_183302_create_image_size_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%image_size}}', [
            'id' => $this->primaryKey(),
            'image_id' => $this->integer()->notNull(),
            'height' => $this->smallInteger(),
            'width' => $this->smallInteger(),
        ]);

        // creates index for column `image_id`
        $this->createIndex(
            '{{%idx-image_size-image_id}}',
            '{{%image_size}}',
            'image_id'
        );

        // add foreign key for table `{{%image}}`
        $this->addForeignKey(
            '{{%fk-image_size-image_id}}',
            '{{%image_size}}',
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
            '{{%fk-image_size-image_id}}',
            '{{%image_size}}'
        );

        // drops index for column `image_id`
        $this->dropIndex(
            '{{%idx-image_size-image_id}}',
            '{{%image_size}}'
        );

        $this->dropTable('{{%image_size}}');
    }
}
