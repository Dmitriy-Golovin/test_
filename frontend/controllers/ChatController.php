<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\ChatForm;
use yii\helpers\ArrayHelper;
use common\models\User;

class ChatController extends Controller
{
	public function behaviors()
	{
        $behaviors['verbs'] = [
                'class' => VerbFilter::className(),
                'actions' => [
                    'send' => ['POST'],
                ],
            ];

		$behaviors['access'] = [
			'class' => \yii\filters\AccessControl::className(),
			'rules' => [

				[
					'allow' => false,
					'actions' => ['index', 'send'],
					'roles' => ['?'],
				],

				[
					'allow' => true,
					'actions' => ['index'],
					'roles' => ['@'],
				],

				[
					'allow' => true,
					'actions' => ['send'],
					'matchCallback' => function ($rule, $action) {
                        $user = \Yii::$app->user->identity;
						return $user->role != $user::ROLE_GUEST;
                    }
				],
			],
		];

        return $behaviors;
	}

	public function actionIndex()
	{
		$model = new ChatForm();

		return $this->render('index', [
			'model' => $model,
		]);
	}

	public function actionSend()
	{
		$model = new ChatForm();

		if ($model->load(\Yii::$app->request->post())) {
			if (!$model->saveMessage()) {
				\Yii::$app->session->setFlash('error', $model->getFirstError(''));
				return $this->render('index', [
					'model' => $model,
				]);
			}
			
			
			return $this->redirect(['index']);
		}
	}
}