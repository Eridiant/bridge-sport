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
            'category_id' => $this->integer(),
            'name' => $this->string(255),
            'slug' => $this->string(255),
            'description' => $this->text(),
            'img' => $this->string(255),
            'keywords' => $this->string(255),
            'active' => $this->smallInteger(1)->notNull()->defaultValue(0),
        ]);
        $this->addForeignKey(
            'category-post',
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
