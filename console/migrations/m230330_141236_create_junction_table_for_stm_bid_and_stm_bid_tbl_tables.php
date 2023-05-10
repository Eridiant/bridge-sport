<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stm_bid_stm_bid_tbl}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%stm_bid}}`
 * - `{{%stm_bid_tbl}}`
 */
class m230330_141236_create_junction_table_for_stm_bid_and_stm_bid_tbl_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stm_bid_stm_bid_tbl}}', [
            'stm_bid_id' => $this->integer(),
            'stm_bid_tbl_id' => $this->integer(),
            'PRIMARY KEY(stm_bid_id, stm_bid_tbl_id)',
        ]);

        // creates index for column `stm_bid_id`
        $this->createIndex(
            '{{%idx-stm_bid_stm_bid_tbl-stm_bid_id}}',
            '{{%stm_bid_stm_bid_tbl}}',
            'stm_bid_id'
        );

        // add foreign key for table `{{%stm_bid}}`
        $this->addForeignKey(
            '{{%fk-stm_bid_stm_bid_tbl-stm_bid_id}}',
            '{{%stm_bid_stm_bid_tbl}}',
            'stm_bid_id',
            '{{%stm_bid}}',
            'id',
            'CASCADE'
        );

        // creates index for column `stm_bid_tbl_id`
        $this->createIndex(
            '{{%idx-stm_bid_stm_bid_tbl-stm_bid_tbl_id}}',
            '{{%stm_bid_stm_bid_tbl}}',
            'stm_bid_tbl_id'
        );

        // add foreign key for table `{{%stm_bid_tbl}}`
        $this->addForeignKey(
            '{{%fk-stm_bid_stm_bid_tbl-stm_bid_tbl_id}}',
            '{{%stm_bid_stm_bid_tbl}}',
            'stm_bid_tbl_id',
            '{{%stm_bid_tbl}}',
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
            '{{%fk-stm_bid_stm_bid_tbl-stm_bid_id}}',
            '{{%stm_bid_stm_bid_tbl}}'
        );

        // drops index for column `stm_bid_id`
        $this->dropIndex(
            '{{%idx-stm_bid_stm_bid_tbl-stm_bid_id}}',
            '{{%stm_bid_stm_bid_tbl}}'
        );

        // drops foreign key for table `{{%stm_bid_tbl}}`
        $this->dropForeignKey(
            '{{%fk-stm_bid_stm_bid_tbl-stm_bid_tbl_id}}',
            '{{%stm_bid_stm_bid_tbl}}'
        );

        // drops index for column `stm_bid_tbl_id`
        $this->dropIndex(
            '{{%idx-stm_bid_stm_bid_tbl-stm_bid_tbl_id}}',
            '{{%stm_bid_stm_bid_tbl}}'
        );

        $this->dropTable('{{%stm_bid_stm_bid_tbl}}');
    }
}
