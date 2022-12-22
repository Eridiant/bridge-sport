<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%syst}}`.
 */
class m220921_165038_create_syst_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%syst}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11),
        ]);

        // creates index for column `slug`
        $this->createIndex(
            '{{%idx-syst-slug}}',
            '{{%syst}}',
            'slug'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        // drops index for column `slug`
        $this->dropIndex(
            '{{%idx-syst-slug}}',
            '{{%syst}}'
        );

        $this->dropTable('{{%syst}}');
    }
}
