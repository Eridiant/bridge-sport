<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%survey}}`.
 */
class m220119_182137_create_survey_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%survey}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull(),
            'img' => $this->string(255),
            'keywords' => $this->string(255),
            'preview' => $this->text(),
            'description' => $this->text(),
            'type' => $this->tinyInteger(),
            'access' => $this->tinyInteger(),
            'active' => $this->tinyInteger(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11),
            'deleted_at' => $this->integer(11),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-survey-user_id}}',
            '{{%survey}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-survey-user_id}}',
            '{{%survey}}',
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
            '{{%fk-survey-user_id}}',
            '{{%survey}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-survey-user_id}}',
            '{{%survey}}'
        );

        $this->dropTable('{{%survey}}');
    }
}
