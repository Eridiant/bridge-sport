<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%post}}`.
 */
class m220822_145607_add_survey_column_to_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%post}}', 'comments_status', $this->tinyInteger()->notNull()->defaultValue(1));
        $this->addColumn('{{%post}}', 'survey_id', $this->integer(11));



        // creates index for column `survey_id`
        $this->createIndex(
            '{{%idx-post-survey_id}}',
            '{{%post}}',
            'survey_id'
        );

        // add foreign key for table `{{%survey}}`
        $this->addForeignKey(
            '{{%fk-post-survey_id}}',
            '{{%post}}',
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
            '{{%fk-post-survey_id}}',
            '{{%post}}'
        );

        // drops index for column `survey_id`
        $this->dropIndex(
            '{{%idx-post-survey_id}}',
            '{{%post}}'
        );

        $this->dropColumn('{{%post}}', 'comments_status');
        $this->dropColumn('{{%post}}', 'survey_id');
    }
}
