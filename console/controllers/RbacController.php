<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $guest = $auth->createRole('guest');
        $guest->description = 'Гость';
        $auth->add($guest);

        $user = $auth->createRole('user');
        $guest->description = 'Пользователь';
        $auth->add($user);

        $admin = $auth->createRole('admin');
        $guest->description = 'Админ';
        $auth->add($admin);
        $auth->addChild($admin, $guest);
        $auth->addChild($admin, $user);
   }

}