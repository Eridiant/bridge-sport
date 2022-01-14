<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post_taxonomy}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%post}}`
 * - `{{%taxonomy}}`
 */
class m220111_193518_create_post_taxonomy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post_taxonomy}}', [
            'post_id' => $this->integer()->notNull(),
            'taxonomy_id' => $this->integer(11)->notNull(),
        ]);

        $this->addPrimaryKey(
            'pk-post_taxonomy',
            '{{%post_taxonomy}}',
            [
                'post_id',
                'taxonomy_id'
            ]
        );

        // creates index for column `post_id`
        $this->createIndex(
            '{{%idx-post_taxonomy-post_id}}',
            '{{%post_taxonomy}}',
            'post_id'
        );

        // add foreign key for table `{{%post}}`
        $this->addForeignKey(
            '{{%fk-post_taxonomy-post_id}}',
            '{{%post_taxonomy}}',
            'post_id',
            '{{%post}}',
            'id',
            'CASCADE'
        );

        // creates index for column `taxonomy_id`
        $this->createIndex(
            '{{%idx-post_taxonomy-taxonomy_id}}',
            '{{%post_taxonomy}}',
            'taxonomy_id'
        );

        // add foreign key for table `{{%taxonomy}}`
        $this->addForeignKey(
            '{{%fk-post_taxonomy-taxonomy_id}}',
            '{{%post_taxonomy}}',
            'taxonomy_id',
            '{{%taxonomy}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%post}}`
        $this->dropForeignKey(
            '{{%fk-post_taxonomy-post_id}}',
            '{{%post_taxonomy}}'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            '{{%idx-post_taxonomy-post_id}}',
            '{{%post_taxonomy}}'
        );

        // drops foreign key for table `{{%taxonomy}}`
        $this->dropForeignKey(
            '{{%fk-post_taxonomy-taxonomy_id}}',
            '{{%post_taxonomy}}'
        );

        // drops index for column `taxonomy_id`
        $this->dropIndex(
            '{{%idx-post_taxonomy-taxonomy_id}}',
            '{{%post_taxonomy}}'
        );

        $this->dropTable('{{%post_taxonomy}}');
    }
}
