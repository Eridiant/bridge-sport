<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%quiz}}`.
 */
class m220119_182406_create_quiz_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%quiz}}', [
            'id' => $this->primaryKey(),
            'survey_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer(11)->notNull()->defaultValue(0),
            'answer_id' => $this->integer(11),
            'img' => $this->string(255),
            'description' => $this->text(),
            'type' => $this->tinyInteger(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11),
            'deleted_at' => $this->integer(11),
        ]);

        // creates index for column `survey_id`
        $this->createIndex(
            '{{%idx-quiz-survey_id}}',
            '{{%quiz}}',
            'survey_id'
        );

        // add foreign key for table `{{%survey}}`
        $this->addForeignKey(
            '{{%fk-quiz-survey_id}}',
            '{{%quiz}}',
            'survey_id',
            '{{%survey}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%survey}}`
        $this->dropForeignKey(
            '{{%fk-quiz-survey_id}}',
            '{{%quiz}}'
        );

        // drops index for column `survey_id`
        $this->dropIndex(
            '{{%idx-quiz-survey_id}}',
            '{{%quiz}}'
        );

        $this->dropTable('{{%quiz}}');
    }
}
