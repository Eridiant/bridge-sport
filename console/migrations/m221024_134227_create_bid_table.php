<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bid}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%system}}`
 */
class m221024_134227_create_bid_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bid}}', [
            'id' => $this->primaryKey(),
            'system_id' => $this->integer()->notNull(),
            'bid_tbl_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer(11)->notNull()->defaultValue(0),
            // 'answer_id' => $this->integer(11),
            'variant_id' => $this->integer(11),
            'vulnerable_id' => $this->integer(11),
            'pass' => $this->tinyInteger(),
            'alert' => $this->tinyInteger(),
            'excerpt' => $this->text(),
            'description' => $this->text(),
            'updated_at' => $this->integer(11),
            'created_at' => $this->integer(11)->notNull(),
            'deprecated_at' => $this->integer(11),
        ]);

        // creates index for column `system_id`
        $this->createIndex(
            '{{%idx-bid-system_id}}',
            '{{%bid}}',
            'system_id'
        );

        // add foreign key for table `{{%system}}`
        $this->addForeignKey(
            '{{%fk-bid-system_id}}',
            '{{%bid}}',
            'system_id',
            '{{%system}}',
            'id',
            'CASCADE'
        );

        // creates index for column `bid_tbl_id`
        $this->createIndex(
            '{{%idx-bid-bid_tbl_id}}',
            '{{%bid}}',
            'bid_tbl_id'
        );

        // add foreign key for table `{{%bid_tbl}}`
        $this->addForeignKey(
            '{{%fk-bid-bid_tbl_id}}',
            '{{%bid}}',
            'bid_tbl_id',
            '{{%bid_tbl}}',
            'id',
            'CASCADE'
        );

        // creates index for column `variant_id`
        $this->createIndex(
            '{{%idx-bid-variant_id}}',
            '{{%bid}}',
            'variant_id'
        );

        // add foreign key for table `{{%variant}}`
        $this->addForeignKey(
            '{{%fk-bid-variant_id}}',
            '{{%bid}}',
            'variant_id',
            '{{%variant}}',
            'id',
            'CASCADE'
        );

        // creates index for column `vulnerable_id`
        $this->createIndex(
            '{{%idx-bid-vulnerable_id}}',
            '{{%bid}}',
            'vulnerable_id'
        );

        // add foreign key for table `{{%vulnerable}}`
        $this->addForeignKey(
            '{{%fk-bid-vulnerable_id}}',
            '{{%bid}}',
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
            '{{%fk-bid-vulnerable_id}}',
            '{{%bid}}'
        );

        // drops index for column `vulnerable_id`
        $this->dropIndex(
            '{{%idx-bid-vulnerable_id}}',
            '{{%bid}}'
        );

        // drops foreign key for table `{{%variant}}`
        $this->dropForeignKey(
            '{{%fk-bid-variant_id}}',
            '{{%bid}}'
        );

        // drops index for column `variant_id`
        $this->dropIndex(
            '{{%idx-bid-variant_id}}',
            '{{%bid}}'
        );

        // drops foreign key for table `{{%bid_tbl}}`
        $this->dropForeignKey(
            '{{%fk-bid-bid_tbl_id}}',
            '{{%bid}}'
        );

        // drops index for column `bid_tbl_id`
        $this->dropIndex(
            '{{%idx-bid-bid_tbl_id}}',
            '{{%bid}}'
        );

        // drops foreign key for table `{{%system}}`
        $this->dropForeignKey(
            '{{%fk-bid-system_id}}',
            '{{%bid}}'
        );

        // drops index for column `system_id`
        $this->dropIndex(
            '{{%idx-bid-system_id}}',
            '{{%bid}}'
        );

        $this->dropTable('{{%bid}}');
    }
}
