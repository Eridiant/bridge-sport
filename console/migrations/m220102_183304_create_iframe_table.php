<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%iframe}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%image}}`
 */
class m220102_183304_create_iframe_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%iframe}}', [
            'id' => $this->primaryKey(),
            'image_id' => $this->integer(),
            'frame' => $this->text(),
            'only_img' => $this->tinyInteger(3),
            'preview' => $this->tinyInteger(3),
        ]);

        // creates index for column `image_id`
        $this->createIndex(
            '{{%idx-iframe-image_id}}',
            '{{%iframe}}',
            'image_id'
        );

        // add foreign key for table `{{%image}}`
        $this->addForeignKey(
            '{{%fk-iframe-image_id}}',
            '{{%iframe}}',
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
            '{{%fk-iframe-image_id}}',
            '{{%iframe}}'
        );

        // drops index for column `image_id`
        $this->dropIndex(
            '{{%idx-iframe-image_id}}',
            '{{%iframe}}'
        );

        $this->dropTable('{{%iframe}}');
    }
}
