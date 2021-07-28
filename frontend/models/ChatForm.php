<?php

namespace frontend\models;

use common\models\User;
use common\models\Message;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ChatForm extends Message {

    public function getMessageList($params)
    {
        $user = \Yii::$app->user->identity;
        $query = Message::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['messageId' => SORT_ASC]],
            'pagination' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if (empty($user) || !\Yii::$app->user->can('admin')) {
            $query->andWhere(['correct' => Message::CORRECT]);
        }

        return $dataProvider;
    }

    public function saveMessage()
    {
    	$user = \Yii::$app->user->identity;
    	$messageModel = new Message();
    	$messageModel->userId = $user->userId;
    	$messageModel->text = $this->text;
    	$messageModel->createdAt = time();
    	$messageModel->updatedAt = time();

    	if (!$messageModel-> save()) {
    		$this->addError('', 'Не удалось отправить сообщение');
    		return false;
    	}

    	return true;
    }
}