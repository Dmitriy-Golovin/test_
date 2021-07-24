<?php

use yii\db\Migration;

/**
 * Class m210724_102039_rename_id_column_user_table
 */
class m210724_102039_rename_id_column_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%user}}', 'id', 'userId');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%user}}', 'userId', 'id');
    }
}
