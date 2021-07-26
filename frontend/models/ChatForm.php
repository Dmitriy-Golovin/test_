<?php

namespace frontend\models;

use common\models\User;
use common\models\Message;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ChatForm extends Model {

	public $text;

	public function rules()
    {
        return [
            ['text', 'required'],
            ['text', 'string', 'max' => 1000],
        ];
    }

    public function getMessageList()
    {
        $user = \Yii::$app->user->identity;
        $queryMessage = Message::find();

        if (empty($user) || !User::currentUserRoleIs('admin', $user->userId)) {
            $queryMessage->andWhere(['correct' => Message::CORRECT]);
        }

        return $queryMessage;
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