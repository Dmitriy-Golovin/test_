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
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property User $user
 */
class Message extends \yii\db\ActiveRecord
{
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
            [['text'], 'string'],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'userId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'messageId' => 'Message ID',
            'userId' => 'User ID',
            'text' => 'Text',
            'correct' => 'Correct',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
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
}
