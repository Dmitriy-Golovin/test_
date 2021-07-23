<?php

namespace backend\models;

use common\models\Product;
use yii\data\ActiveDataProvider;

class ProductForm extends Product
{
    public $searchString;
    public $fieldList;
    public $imagePathColumn;
    public $SKUColumn;
    public $nameColumn;
    public $amountColumn;
    public $typeColumn;

    public function rules()
    {
        return [
            ['searchString', 'string'],
            [['imagePathColumn', 'SKUColumn', 'nameColumn', 'amountColumn', 'typeColumn'], 'default', 'value' => 1],
        ];
    }

    public function search($params)
    {
        $query = Product::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['productId' => SORT_ASC]],
            'pagination' => [
                'forcePageParam' => false,
                'pageSizeParam' => false,
                'pageSize' => 10
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if (!empty($this->searchString)) {
            if ($this->SKUColumn == 1 && $this->nameColumn == 1) {
    	        $query->andFilterWhere(['like', 'SKU', $this->searchString])
    	        	->orFilterWhere(['like', 'name', $this->searchString]);
            }

            if ($this->SKUColumn == 1 && $this->nameColumn == 0) {
                $query->andFilterWhere(['like', 'SKU', $this->searchString]);
            }

            if ($this->SKUColumn == 0 && $this->nameColumn == 1) {
                $query->andFilterWhere(['like', 'name', $this->searchString]);
            }
        }

        return $dataProvider;
    }
}