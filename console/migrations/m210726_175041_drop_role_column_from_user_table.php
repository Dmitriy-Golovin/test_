<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%user}}`.
 */
class m210726_175041_drop_role_column_from_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%user}}', 'role');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%user}}', 'role', $this->integer());
    }
}
