<?php

namespace frontend\models;

use common\models\User;
use common\models\Message;
use yii\base\InvalidArgumentException;
use yii\base\Model;

class ChatForm extends Model {

	public $text;

	public function rules()
    {
        return [
            ['text', 'required'],
            ['text', 'string', 'max' => 1000],
        ];
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