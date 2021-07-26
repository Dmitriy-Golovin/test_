<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%product}}`.
 */
class m210726_184105_drop_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('{{%product}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->createTable('{{%product}}', [
            'productId' => $this->primaryKey(),
            'imagePath' => $this->string(),
            'SKU' => $this->string(),
            'name' => $this->string(),
            'amount' => $this->integer(),
            'type' => $this->integer(),
        ]);
    }
}
