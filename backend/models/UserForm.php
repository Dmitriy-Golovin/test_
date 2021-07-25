<?php

namespace backend\models;

use common\models\User;
use yii\data\ActiveDataProvider;

class UserForm extends User
{
    public function rules()
    {
        return [

        ];
    }

    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['userId' => SORT_ASC]],
            'pagination' => [
                'forcePageParam' => false,
                'pageSizeParam' => false,
                'pageSize' => 20
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
}