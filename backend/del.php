<?php
class m230327
{
    public function actionTest()
    {
        $opponent = 0;
        $parent_id = 0;
        $pass = 0;
        $system_id = 1;

        // $sql = "SELECT DISTINCTROW *
        // FROM {{%bid}}
        // LEFT JOIN {{%bid_bid_tbl}} ON {{%bid_bid_tbl}}.bid_id = {{%bid}}.id
        // LEFT JOIN {{%bid_tbl}} ON {{%bid_tbl}}.id = {{%bid_bid_tbl}}.bid_tbl_id
        // LEFT JOIN {{%bid_tbl}} ON {{%bid_tbl}}.id = {{%bid}}.bid_tbl_id
        // WHERE system_id = {$system_id} AND parent_id = {$parent_id} AND pass = {$pass} AND opponent = {$opponent}
        // ORDER BY {{%bid_tbl}}.id
        // ";

        $sql = "SELECT {{%bid}}.id, parent_id, {{%bid}}.bid_tbl_id AS bti,  pass, excerpt, num, `description`, bid, opponent
        FROM {{%bid}}
        LEFT JOIN {{%bid_tbl}} ON {{%bid_tbl}}.id = {{%bid}}.bid_tbl_id
        -- LEFT JOIN {{%bid_bid_tbl}} ON {{%bid_bid_tbl}}.bid_id = {{%bid}}.id
        -- LEFT JOIN {{%bid_tbl}} ON {{%bid_tbl}}.id = {{%bid_bid_tbl}}.bid_tbl_id
        WHERE system_id = {$system_id} AND parent_id = {$parent_id} AND pass = {$pass} AND opponent = {$opponent}
        ORDER BY {{%bid_tbl}}.id
        ";
        $model = \Yii::$app->db->createCommand($sql)->queryAll();

        var_dump('<pre>');
        var_dump($model);
        var_dump('</pre>');
        die;
        
    }

    // model

    /**
     * Gets query for [[BidTbls]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBidTbls()
    {
        return $this->hasMany(BidTbl::class, ['id' => 'bid_tbl_id'])->viaTable('bsip_bid_bid_tbl', ['bid_id' => 'id']);
    }

    /**
     * Gets query for [[Bid]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComplexBids()
    {
        return $this->hasMany(Bid::class, ['id' => 'bid_id'])->viaTable('bsip_bid_bid', ['parent_id' => 'id']);
    }

    /**
     * Gets query for [[Bid]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComplexParent()
    {
        return $this->hasOne(Bid::class, ['id' => 'parent_id'])->viaTable('bsip_bid_bid', ['bid_id' => 'id']);
    }
    // end model
}


    // miigrate

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bid_bid_tbl}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%bid}}`
 * - `{{%bid_tbl}}`
 */
class m230327_164456_create_junction_table_for_bid_and_bid_tbl_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bid_bid_tbl}}', [
            'bid_id' => $this->integer(),
            'bid_tbl_id' => $this->integer(),
            'PRIMARY KEY(bid_id, bid_tbl_id)',
        ]);

        // creates index for column `bid_id`
        $this->createIndex(
            '{{%idx-bid_bid_tbl-bid_id}}',
            '{{%bid_bid_tbl}}',
            'bid_id'
        );

        // add foreign key for table `{{%bid}}`
        $this->addForeignKey(
            '{{%fk-bid_bid_tbl-bid_id}}',
            '{{%bid_bid_tbl}}',
            'bid_id',
            '{{%bid}}',
            'id',
            'CASCADE'
        );

        // creates index for column `bid_tbl_id`
        $this->createIndex(
            '{{%idx-bid_bid_tbl-bid_tbl_id}}',
            '{{%bid_bid_tbl}}',
            'bid_tbl_id'
        );

        // add foreign key for table `{{%bid_tbl}}`
        $this->addForeignKey(
            '{{%fk-bid_bid_tbl-bid_tbl_id}}',
            '{{%bid_bid_tbl}}',
            'bid_tbl_id',
            '{{%bid_tbl}}',
            'id',
            'CASCADE'
        );

        $this->alterColumn('{{%bid}}','bid_tbl_id','integer NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%bid}}`
        $this->dropForeignKey(
            '{{%fk-bid_bid_tbl-bid_id}}',
            '{{%bid_bid_tbl}}'
        );

        // drops index for column `bid_id`
        $this->dropIndex(
            '{{%idx-bid_bid_tbl-bid_id}}',
            '{{%bid_bid_tbl}}'
        );

        // drops foreign key for table `{{%bid_tbl}}`
        $this->dropForeignKey(
            '{{%fk-bid_bid_tbl-bid_tbl_id}}',
            '{{%bid_bid_tbl}}'
        );

        // drops index for column `bid_tbl_id`
        $this->dropIndex(
            '{{%idx-bid_bid_tbl-bid_tbl_id}}',
            '{{%bid_bid_tbl}}'
        );

        $this->alterColumn('{{%bid}}','bid_tbl_id','integer NOT NULL');

        $this->dropTable('{{%bid_bid_tbl}}');
    }
}

/**
 * Handles the creation of table `{{%bid_bid}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%bid}}`
 */
class m230327_133406_create_junction_table_for_bid_and_bid_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bid_bid}}', [
            'parent_id' => $this->integer(),
            'bid_id' => $this->integer(),
            'PRIMARY KEY(parent_id, bid_id)',
        ]);

        // creates index for column `bid_id`
        $this->createIndex(
            '{{%idx-bid_bid-bid_id}}',
            '{{%bid_bid}}',
            'bid_id'
        );

        // add foreign key for table `{{%bid}}`
        $this->addForeignKey(
            '{{%fk-bid_bid-bid_id}}',
            '{{%bid_bid}}',
            'bid_id',
            '{{%bid}}',
            'id',
            'CASCADE'
        );

        // creates index for column `parent_id`
        $this->createIndex(
            '{{%idx-bid_bid-parent_id}}',
            '{{%bid_bid}}',
            'parent_id'
        );

        // add foreign key for table `{{%bid}}`
        $this->addForeignKey(
            '{{%fk-bid_bid-parent_id}}',
            '{{%bid_bid}}',
            'parent_id',
            '{{%bid}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%bid}}`
        $this->dropForeignKey(
            '{{%fk-bid_bid-parent_id}}',
            '{{%bid_bid}}'
        );

        // drops index for column `parent_id`
        $this->dropIndex(
            '{{%idx-bid_bid-parent_id}}',
            '{{%bid_bid}}'
        );

        // drops foreign key for table `{{%bid}}`
        $this->dropForeignKey(
            '{{%fk-bid_bid-bid_id}}',
            '{{%bid_bid}}'
        );

        // drops index for column `bid_id`
        $this->dropIndex(
            '{{%idx-bid_bid-bid_id}}',
            '{{%bid_bid}}'
        );

        $this->dropTable('{{%bid_bid}}');
    }
}
