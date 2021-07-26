<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\User;
use yii\console\ExitCode;
use yii\helpers\Console;

class RbacAdminAssignController extends Controller
{
    public function actionInit($admin){

        if (empty($admin) || !is_string($admin)) {
            $this->stdout("Param 'admin' must be set!\n", Console::BG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $user = (new User())->findByUsername($admin);

        if (empty($user)) {
            $this->stdout("User witch username:'$admin' is not found!\n", Console::BG_RED);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $auth = Yii::$app->authManager;

        $role = $auth->getRole('admin');

        $auth->revokeAll($user->userId);

        $auth->assign($role, $user->userId);

        $this->stdout("Done!\n", Console::BOLD);
        return ExitCode::OK;
   }
}