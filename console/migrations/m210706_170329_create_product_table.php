<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m210706_170329_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
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

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }
}
