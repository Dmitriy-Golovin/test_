<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property int $messageId
 * @property int|null $userId
 * @property string|null $text
 * @property int|null $correct
 * @property int|null $createdAt
 * @property int|null $updatedAt
 *
 * @property User $user
 */
class Message extends \yii\db\ActiveRecord
{
    const CORRECT = 1;
    const INCORRECT = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'correct', 'createdAt', 'updatedAt'], 'integer'],
            [['text'], 'string', 'max' => 1000],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'userId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'messageId' => 'ID',
            'author' => 'Автор сообщения',
            'text' => 'Текст сообщения',
            'correct' => 'Correct',
            'createdAt' => 'Дата создания',
            'updatedAt' => 'Дата обновления',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['userId' => 'userId']);
    }

    public function setIncorrect()
    {
        $this->correct = self::INCORRECT;

        if (!$this->save()) {
            return false;
        }

        return true;
    }

    public function setCorrect()
    {
        $this->correct = self::CORRECT;

        if (!$this->save()) {
            return false;
        }

        return true;
    }
}
