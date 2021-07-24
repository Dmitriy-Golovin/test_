<?php

use yii\db\Migration;
use common\models\User;

/**
 * Class m210724_091246_add_admin
 */
class m210724_091246_add_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('user', array(
            'email' => \Yii::$app->params['adminEmail'],
            'password_hash' => \Yii::$app->security->generatePasswordHash(\Yii::$app->params['adminPassword']),
            'auth_key' => \Yii::$app->security->generateRandomString(),
            'username' => \Yii::$app->params['adminUsername'],
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
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
