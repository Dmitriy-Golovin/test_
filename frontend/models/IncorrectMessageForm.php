<?php

namespace frontend\models;

use common\models\Message;
use yii\data\ActiveDataProvider;

class IncorrectMessageForm extends Message
{
    public function searchIncorrect($params)
    {
        $query = Message::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['messageId' => SORT_ASC]],
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

        $query->andFilterWhere(['correct' => Message::INCORRECT]);

        return $dataProvider;
    }
}