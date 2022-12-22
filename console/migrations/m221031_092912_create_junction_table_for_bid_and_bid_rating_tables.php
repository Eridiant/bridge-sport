<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_bid_rating}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%bid}}`
 * - `{{%user}}`
 * - `{{%bid_rating}}`
 */
class m221031_092912_create_junction_table_for_bid_and_bid_rating_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_bid_rating}}', [
            'bid_id' => $this->integer(),
            'user_id' => $this->integer(),
            'bid_rating_id' => $this->integer(),
            'message' => $this->text(),
            'PRIMARY KEY(bid_id, user_id, bid_rating_id)',
        ]);

        // creates index for column `bid_id`
        $this->createIndex(
            '{{%idx-user_bid_rating-bid_id}}',
            '{{%user_bid_rating}}',
            'bid_id'
        );

        // add foreign key for table `{{%bid}}`
        $this->addForeignKey(
            '{{%fk-user_bid_rating-bid_id}}',
            '{{%user_bid_rating}}',
            'bid_id',
            '{{%bid}}',
            'id',
            'CASCADE'
        );

        // creates index for column `bid_rating_id`
        $this->createIndex(
            '{{%idx-user_bid_rating-bid_rating_id}}',
            '{{%user_bid_rating}}',
            'bid_rating_id'
        );

        // add foreign key for table `{{%bid_rating}}`
        $this->addForeignKey(
            '{{%fk-user_bid_rating-bid_rating_id}}',
            '{{%user_bid_rating}}',
            'bid_rating_id',
            '{{%bid_rating}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_bid_rating-user_id}}',
            '{{%user_bid_rating}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user_bid_rating-user_id}}',
            '{{%user_bid_rating}}',
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
            '{{%fk-user_bid_rating-user_id}}',
            '{{%user_bid_rating}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_bid_rating-user_id}}',
            '{{%user_bid_rating}}'
        );

        // drops foreign key for table `{{%bid}}`
        $this->dropForeignKey(
            '{{%fk-user_bid_rating-bid_id}}',
            '{{%user_bid_rating}}'
        );

        // drops index for column `bid_id`
        $this->dropIndex(
            '{{%idx-user_bid_rating-bid_id}}',
            '{{%user_bid_rating}}'
        );

        // drops foreign key for table `{{%bid_rating}}`
        $this->dropForeignKey(
            '{{%fk-user_bid_rating-bid_rating_id}}',
            '{{%user_bid_rating}}'
        );

        // drops index for column `bid_rating_id`
        $this->dropIndex(
            '{{%idx-user_bid_rating-bid_rating_id}}',
            '{{%user_bid_rating}}'
        );

        $this->dropTable('{{%user_bid_rating}}');
    }
}
