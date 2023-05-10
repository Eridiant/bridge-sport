<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stm_system_stm_system}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%stm_system}}`
 * - `{{%stm_system}}`
 */
class m230331_113926_create_junction_table_for_stm_system_and_stm_system_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stm_system_stm_system}}', [
            'system_id' => $this->integer(),
            'convention_id' => $this->integer(),
            'PRIMARY KEY(system_id, convention_id)',
        ]);

        // creates index for column `system_id`
        $this->createIndex(
            '{{%idx-stm_system_stm_system-system_id}}',
            '{{%stm_system_stm_system}}',
            'system_id'
        );

        // add foreign key for table `{{%stm_system}}`
        $this->addForeignKey(
            '{{%fk-stm_system_stm_system-system_id}}',
            '{{%stm_system_stm_system}}',
            'system_id',
            '{{%stm_system}}',
            'id',
            'CASCADE'
        );

        // creates index for column `convention_id`
        $this->createIndex(
            '{{%idx-stm_system_stm_system-convention_id}}',
            '{{%stm_system_stm_system}}',
            'convention_id'
        );

        // add foreign key for table `{{%stm_system}}`
        $this->addForeignKey(
            '{{%fk-stm_system_stm_system-convention_id}}',
            '{{%stm_system_stm_system}}',
            'convention_id',
            '{{%stm_system}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%stm_system}}`
        $this->dropForeignKey(
            '{{%fk-stm_system_stm_system-system_id}}',
            '{{%stm_system_stm_system}}'
        );

        // drops index for column `system_id`
        $this->dropIndex(
            '{{%idx-stm_system_stm_system-system_id}}',
            '{{%stm_system_stm_system}}'
        );

        // drops foreign key for table `{{%stm_system}}`
        $this->dropForeignKey(
            '{{%fk-stm_system_stm_system-convention_id}}',
            '{{%stm_system_stm_system}}'
        );

        // drops index for column `convention_id`
        $this->dropIndex(
            '{{%idx-stm_system_stm_system-convention_id}}',
            '{{%stm_system_stm_system}}'
        );

        $this->dropTable('{{%stm_system_stm_system}}');
    }
}
