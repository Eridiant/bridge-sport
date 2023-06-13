<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%stat_user_ip}}`.
 */
class m230613_134717_add_bot_column_to_stat_user_ip_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%stat_user_ip}}', 'city', $this->string(255)->after('device'));
        $this->addColumn('{{%stat_user_ip}}', 'region', $this->string(255)->after('device'));
        $this->addColumn('{{%stat_user_ip}}', 'country_name', $this->string(255)->after('device'));
        $this->addColumn('{{%stat_user_ip}}', 'country_code', $this->string(12)->after('device'));
        $this->addColumn('{{%stat_user_ip}}', 'bot', $this->tinyInteger()->after('device'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%stat_user_ip}}', 'city');
        $this->dropColumn('{{%stat_user_ip}}', 'region');
        $this->dropColumn('{{%stat_user_ip}}', 'country_name');
        $this->dropColumn('{{%stat_user_ip}}', 'country_code');
        $this->dropColumn('{{%stat_user_ip}}', 'bot');
    }
}
