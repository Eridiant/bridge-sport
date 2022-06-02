<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%image_format}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%image}}`
 */
class m220102_183301_create_image_format_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%image_format}}', [
            'id' => $this->primaryKey(),
            'image_id' => $this->integer()->notNull(),
            'format' => $this->string(24),
        ]);

        // creates index for column `image_id`
        $this->createIndex(
            '{{%idx-image_format-image_id}}',
            '{{%image_format}}',
            'image_id'
        );

        // add foreign key for table `{{%image}}`
        $this->addForeignKey(
            '{{%fk-image_format-image_id}}',
            '{{%image_format}}',
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
            '{{%fk-image_format-image_id}}',
            '{{%image_format}}'
        );

        // drops index for column `image_id`
        $this->dropIndex(
            '{{%idx-image_format-image_id}}',
            '{{%image_format}}'
        );

        $this->dropTable('{{%image_format}}');
    }
}
