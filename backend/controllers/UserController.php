<?php
namespace backend\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\UserForm;
use common\models\User;

class UserController extends Controller
{
	public function behaviors()
	{
        $behaviors = [];

		$behaviors['access'] = [
			'class' => \yii\filters\AccessControl::className(),
			'rules' => [
				[
					'allow' => true,
					'actions' => ['index', 'update'],
					'roles' => ['admin'],
				],
			],
		];

        return $behaviors;
	}

	public function actionIndex()
	{
		$searchModel = new UserForm();

        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}

	public function actionUpdate($id)
	{
        $model = User::findOne($id);

        if ($model === null) {
        	throw new NotFoundHttpException('Пользователь не найден.');
        }

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $auth = \Yii::$app->authManager;
	        $role = $auth->getRole($model->role);
	        $auth->revokeAll($model->userId);

	        if ($role !== 'guest') {
	        	$auth->assign($role, $model->userId);
	        }

	        return $this->redirect(['index']);
        }

        return $this->render('update', [
        	'model' => $model,
        ]);
	}
}