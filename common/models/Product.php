<?php

namespace common\models;

use yii\helpers\FileHelper;

/**
 * This is the model class for table "product".
 *
 * @property int $productId
 * @property string|null $imagePath
 * @property string|null $SKU
 * @property string|null $name
 * @property string|null $amount
 * @property int|null $type
 */
class Product extends \yii\db\ActiveRecord
{
    const TYPE_CLOTHES = 1;
    const TYPE_FOOTWEAR = 2;
    const TYPE_ACCESSORIES = 3;

    public $image;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount', 'type'], 'integer'],
            [['imagePath', 'SKU', 'name'], 'string', 'max' => 255],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpeg,png,jpg'],
	    [['SKU', 'name', 'amount'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'productId' => 'Product ID',
            'imagePath' => 'Изображение',
            'SKU' => 'Sku',
            'name' => 'Название',
            'amount' => 'Количество на складе',
            'type' => 'Тип товара',
        ];
    }

    public function checkboxLabels()
    {
        return [
            'imagePathColumn' => 'Изображение',
            'SKUColumn' => 'Sku',
            'nameColumn' => 'Название',
            'amountColumn' => 'Количество на складе',
            'typeColumn' => 'Тип товара',
        ];
    }

    public static function typelabels()
    {
        return [
            self::TYPE_CLOTHES => 'одежда',
            self::TYPE_FOOTWEAR => 'обувь',
            self::TYPE_ACCESSORIES => 'аксессуары',
        ];
    }

    public function getUploadDir()
    {
        $uploadDir = \Yii::getAlias('@createUploadsImg');

        if (!file_exists($uploadDir)) {
            FileHelper::createDirectory($uploadDir);
        }

        return \Yii::getAlias('@createUploadsImg');
    }
}
