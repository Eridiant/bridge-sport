<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%post}}`.
 */
class m230527_152032_add_priority_column_to_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%post}}', 'priority', $this->tinyInteger()->notNull()->defaultValue(5)->after('status'));
        $this->addColumn('{{%post}}', 'changefreq', $this->string(255)->notNull()->defaultValue('weekly')->after('priority'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%post}}', 'priority');
        $this->dropColumn('{{%post}}', 'changefreq');
    }
}
