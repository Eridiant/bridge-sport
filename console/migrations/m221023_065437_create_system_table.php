<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%system}}`.
 */
class m221023_065437_create_system_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%system}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'type' => $this->tinyInteger()->notNull()->defaultValue(0),
            'name' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'hidden' => $this->tinyInteger()->notNull()->defaultValue(0),
            'edit' => $this->tinyInteger()->notNull()->defaultValue(0),
            'updated_at' => $this->integer(11),
            'created_at' => $this->integer(11)->notNull(),
        ]);

        // creates index for column `slug`
        $this->createIndex(
            '{{%idx-system-slug}}',  
            '{{%system}}',
            'slug'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-system-user_id}}',
            '{{%system}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-system-user_id}}',
            '{{%system}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-system-user_id}}',
            '{{%system}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-system-user_id}}',
            '{{%system}}'
        );

        // drops index for column `slug`
        $this->dropIndex(
            '{{%idx-system-slug}}',
            '{{%system}}'
        );

        $this->dropTable('{{%system}}');
    }
}
