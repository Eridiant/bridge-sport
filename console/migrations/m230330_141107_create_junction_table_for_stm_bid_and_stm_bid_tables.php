<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stm_bid_stm_bid}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%stm_bid}}`
 */
class m230330_141107_create_junction_table_for_stm_bid_and_stm_bid_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stm_bid_stm_bid}}', [
            'parent_id' => $this->integer(),
            'bid_id' => $this->integer(),
            'PRIMARY KEY(parent_id, bid_id)',
        ]);

        // creates index for column `bid_id`
        $this->createIndex(
            '{{%idx-stm_bid_stm_bid-bid_id}}',
            '{{%stm_bid_stm_bid}}',
            'bid_id'
        );

        // add foreign key for table `{{%stm_bid}}`
        $this->addForeignKey(
            '{{%fk-stm_bid_stm_bid-bid_id}}',
            '{{%stm_bid_stm_bid}}',
            'bid_id',
            '{{%stm_bid}}',
            'id',
            'CASCADE'
        );

        // creates index for column `parent_id`
        $this->createIndex(
            '{{%idx-stm_bid_stm_bid-parent_id}}',
            '{{%stm_bid_stm_bid}}',
            'parent_id'
        );

        // add foreign key for table `{{%stm_bid}}`
        $this->addForeignKey(
            '{{%fk-stm_bid_stm_bid-parent_id}}',
            '{{%stm_bid_stm_bid}}',
            'parent_id',
            '{{%stm_bid}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%stm_bid}}`
        $this->dropForeignKey(
            '{{%fk-stm_bid_stm_bid-bid_id}}',
            '{{%stm_bid_stm_bid}}'
        );

        // drops index for column `bid_id`
        $this->dropIndex(
            '{{%idx-stm_bid_stm_bid-bid_id}}',
            '{{%stm_bid_stm_bid}}'
        );

        // drops foreign key for table `{{%stm_bid}}`
        $this->dropForeignKey(
            '{{%fk-stm_bid_stm_bid-parent_id}}',
            '{{%stm_bid_stm_bid}}'
        );

        // drops index for column `parent_id`
        $this->dropIndex(
            '{{%idx-stm_bid_stm_bid-parent_id}}',
            '{{%stm_bid_stm_bid}}'
        );

        $this->dropTable('{{%stm_bid_stm_bid}}');
    }
}
