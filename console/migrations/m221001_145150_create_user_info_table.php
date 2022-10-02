<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_info}}`.
 */
class m221001_145150_create_user_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_info}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'viewed_ntf_at' => $this->integer(11),
            'name' => $this->string(255),
            'surname' => $this->string(255),
            'city' => $this->string(255),
            'region' => $this->string(255),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_info-user_id}}',
            '{{%user_info}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user_info-user_id}}',
            '{{%user_info}}',
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
            '{{%fk-user_info-user_id}}',
            '{{%user_info}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_info-user_id}}',
            '{{%user_info}}'
        );

        $this->dropTable('{{%user_info}}');
    }
}
