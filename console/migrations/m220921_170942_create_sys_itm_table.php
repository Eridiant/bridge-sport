<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sys_itm}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%syst}}`
 */
class m220921_170942_create_sys_itm_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sys_itm}}', [
            'id' => $this->primaryKey(),
            'syst_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer(11)->notNull()->defaultValue(0),
            'answer_id' => $this->integer(11),
            'lvl' => $this->tinyInteger(),
            'description' => $this->text(),
            'converted' => $this->text(),
        ]);

        // creates index for column `syst_id`
        $this->createIndex(
            '{{%idx-sys_itm-syst_id}}',
            '{{%sys_itm}}',
            'syst_id'
        );

        // add foreign key for table `{{%syst}}`
        $this->addForeignKey(
            '{{%fk-sys_itm-syst_id}}',
            '{{%sys_itm}}',
            'syst_id',
            '{{%syst}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%syst}}`
        $this->dropForeignKey(
            '{{%fk-sys_itm-syst_id}}',
            '{{%sys_itm}}'
        );

        // drops index for column `syst_id`
        $this->dropIndex(
            '{{%idx-sys_itm-syst_id}}',
            '{{%sys_itm}}'
        );

        $this->dropTable('{{%sys_itm}}');
    }
}
