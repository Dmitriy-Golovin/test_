<?php

use yii\db\Migration;

/**
 * Class m210724_130337_rename_column_message_table
 */
class m210724_130337_rename_column_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%message}}', 'created_at', 'createdAt');
        $this->renameColumn('{{%message}}', 'updated_at', 'updatedAt');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%message}}', 'createdAt', 'created_at');
        $this->renameColumn('{{%message}}', 'updatedAt', 'updated_at');
    }
}
