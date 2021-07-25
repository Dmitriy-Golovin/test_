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
					'matchCallback' => function ($rule, $action) {
                        $user = \Yii::$app->user->identity;
						return !empty($user) ? $user->role == $user::ROLE_ADMIN : false;
                    }
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
            if (!$model->save()) {
                \Yii::$app->session->setFlash('error', $model->getFirstErrors());

                return $this->render('update', [
		        	'model' => $model,
		        ]);
            }

            return $this->redirect(['index']);
        }

        return $this->render('update', [
        	'model' => $model,
        ]);
	}
}