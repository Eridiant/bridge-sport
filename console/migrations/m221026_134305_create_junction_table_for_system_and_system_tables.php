<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%system_system}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%system}}`
 */
class m221026_134305_create_junction_table_for_system_and_system_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%system_system}}', [
            'system_id' => $this->integer(),
            'convention_id' => $this->integer(),
            'PRIMARY KEY(system_id, convention_id)',
        ]);

        // creates index for column `system_id`
        $this->createIndex(
            '{{%idx-system_system-system_id}}',
            '{{%system_system}}',
            'system_id'
        );

        // add foreign key for table `{{%system}}`
        $this->addForeignKey(
            '{{%fk-system_system-system_id}}',
            '{{%system_system}}',
            'system_id',
            '{{%system}}',
            'id',
            'CASCADE'
        );

        // creates index for column `convention_id`
        $this->createIndex(
            '{{%idx-system_system-convention_id}}',
            '{{%system_system}}',
            'convention_id'
        );

        // add foreign key for table `{{%convention}}`
        $this->addForeignKey(
            '{{%fk-system_system-convention_id}}',
            '{{%system_system}}',
            'convention_id',
            '{{%system}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%convention}}`
        $this->dropForeignKey(
            '{{%fk-system_system-convention_id}}',
            '{{%system_system}}'
        );

        // drops index for column `convention_id`
        $this->dropIndex(
            '{{%idx-system_system-convention_id}}',
            '{{%system_system}}'
        );

        // drops foreign key for table `{{%system}}`
        $this->dropForeignKey(
            '{{%fk-system_system-system_id}}',
            '{{%system_system}}'
        );

        // drops index for column `system_id`
        $this->dropIndex(
            '{{%idx-system_system-system_id}}',
            '{{%system_system}}'
        );

        $this->dropTable('{{%system_system}}');
    }
}
