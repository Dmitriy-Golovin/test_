<?php

use yii\db\Migration;
use common\models\User;

/**
 * Class m210724_100240_add_admin
 */
class m210724_100240_add_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('user', array(
            'email' =>  \Yii::$app->params['adminPassword'],
            'password_hash' => \Yii::$app->security->generatePasswordHash(\Yii::$app->params['adminPassword']),
            'username' => \Yii::$app->params['adminUsername'],
            'auth_key' => \Yii::$app->security->generateRandomString(),
            'status' => User::STATUS_ACTIVE,
            'role' => User::ROLE_ADMIN,
            'created_at' => time(),
            'updated_at' => time()
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
    }
}
