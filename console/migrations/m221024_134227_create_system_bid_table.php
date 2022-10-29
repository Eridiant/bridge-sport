<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%system_bid}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%system}}`
 */
class m221024_134227_create_system_bid_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%system_bid}}', [
            'id' => $this->primaryKey(),
            'system_id' => $this->integer()->notNull(),
            'bid_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer(11)->notNull()->defaultValue(0),
            'answer_id' => $this->integer(11),
            'variant_id' => $this->integer(11),
            'vulnerable_id' => $this->integer(11),
            'excerpt' => $this->text(),
            'description' => $this->text(),
            'updated_at' => $this->integer(11),
            'created_at' => $this->integer(11)->notNull(),
        ]);

        // creates index for column `system_id`
        $this->createIndex(
            '{{%idx-system_bid-system_id}}',
            '{{%system_bid}}',
            'system_id'
        );

        // add foreign key for table `{{%system}}`
        $this->addForeignKey(
            '{{%fk-system_bid-system_id}}',
            '{{%system_bid}}',
            'system_id',
            '{{%system}}',
            'id',
            'CASCADE'
        );

        // creates index for column `bid_id`
        $this->createIndex(
            '{{%idx-system_bid-bid_id}}',
            '{{%system_bid}}',
            'bid_id'
        );

        // add foreign key for table `{{%bid}}`
        $this->addForeignKey(
            '{{%fk-system_bid-bid_id}}',
            '{{%system_bid}}',
            'bid_id',
            '{{%bid}}',
            'id',
            'CASCADE'
        );

        // creates index for column `variant_id`
        $this->createIndex(
            '{{%idx-system_bid-variant_id}}',
            '{{%system_bid}}',
            'variant_id'
        );

        // add foreign key for table `{{%variant}}`
        $this->addForeignKey(
            '{{%fk-system_bid-variant_id}}',
            '{{%system_bid}}',
            'variant_id',
            '{{%variant}}',
            'id',
            'CASCADE'
        );

        // creates index for column `vulnerable_id`
        $this->createIndex(
            '{{%idx-system_bid-vulnerable_id}}',
            '{{%system_bid}}',
            'vulnerable_id'
        );

        // add foreign key for table `{{%vulnerable}}`
        $this->addForeignKey(
            '{{%fk-system_bid-vulnerable_id}}',
            '{{%system_bid}}',
            'vulnerable_id',
            '{{%vulnerable}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%vulnerable}}`
        $this->dropForeignKey(
            '{{%fk-system_bid-vulnerable_id}}',
            '{{%system_bid}}'
        );

        // drops index for column `vulnerable_id`
        $this->dropIndex(
            '{{%idx-system_bid-vulnerable_id}}',
            '{{%system_bid}}'
        );

        // drops foreign key for table `{{%variant}}`
        $this->dropForeignKey(
            '{{%fk-system_bid-variant_id}}',
            '{{%system_bid}}'
        );

        // drops index for column `variant_id`
        $this->dropIndex(
            '{{%idx-system_bid-variant_id}}',
            '{{%system_bid}}'
        );

        // drops foreign key for table `{{%bid}}`
        $this->dropForeignKey(
            '{{%fk-system_bid-bid_id}}',
            '{{%system_bid}}'
        );

        // drops index for column `bid_id`
        $this->dropIndex(
            '{{%idx-system_bid-bid_id}}',
            '{{%system_bid}}'
        );

        // drops foreign key for table `{{%system}}`
        $this->dropForeignKey(
            '{{%fk-system_bid-system_id}}',
            '{{%system_bid}}'
        );

        // drops index for column `system_id`
        $this->dropIndex(
            '{{%idx-system_bid-system_id}}',
            '{{%system_bid}}'
        );

        $this->dropTable('{{%system_bid}}');
    }
}
