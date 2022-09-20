<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%auth_assignment}}`.
 */
class m220903_173146_create_auth_assignment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%auth_assignment}}', [
            'item_name' => $this->string(64)->notNull(),
            'user_id' => $this->string(64)->notNull(),
            'baned_at' => $this->integer(),
            'created_at' => $this->integer(),
        ]);

        $this->addPrimaryKey('auth_assignment_pk', '{{%auth_assignment}}', ['item_name', 'user_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropPrimaryKey(['item_name', 'user_id'], '{{%auth_assignment}}');
        $this->dropTable('{{%auth_assignment}}');
    }
}
