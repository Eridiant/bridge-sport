<?php

use yii\db\Migration;

/**
 * Class m230329_184502_create_stm_system_tables
 */
class m230329_184502_create_stm_system_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stm_system}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
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
            '{{%idx-stm_system-slug}}',  
            '{{%stm_system}}',
            'slug'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-stm_system-user_id}}',
            '{{%stm_system}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-stm_system-user_id}}',
            '{{%stm_system}}',
            'user_id',
            '{{%user}}',
            'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-stm_system-user_id}}',
            '{{%stm_system}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-stm_system-user_id}}',
            '{{%stm_system}}'
        );

        // drops index for column `slug`
        $this->dropIndex(
            '{{%idx-stm_system-slug}}',
            '{{%stm_system}}'
        );

        $this->dropTable('{{%stm_system}}');
    }
}
