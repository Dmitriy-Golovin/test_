<?php
namespace frontend\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\ChatForm;
use frontend\models\IncorrectMessageForm;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\Message;

class ChatController extends Controller
{
	public function behaviors()
	{
        $behaviors['verbs'] = [
                'class' => VerbFilter::className(),
                'actions' => [
                    'send' => ['POST'],
                    'set-incorrect' => ['POST'],
                ],
            ];

		$behaviors['access'] = [
			'class' => \yii\filters\AccessControl::className(),
			'rules' => [
				[
					'allow' => true,
					'actions' => ['index'],
					'roles' => ['guest', 'user', 'admin'],
				],

				[
					'allow' => true,
					'actions' => ['send'],
					'roles' => ['user', 'admin'],
				],

				[
					'allow' => true,
					'actions' => ['incorrect', 'set-incorrect', 'set-correct'],
					'roles' => ['admin'],
				],
			],
		];

        return $behaviors;
	}

	public function actionIndex()
	{
		$model = new ChatForm();
		$dataProvider = $model->getMessageList(\Yii::$app->request->queryParams);

		return $this->render('index', [
			'model' => $model,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionIncorrect()
	{
        $searchModel = new IncorrectMessageForm();

        $dataProvider = $searchModel->searchIncorrect(\Yii::$app->request->queryParams);

        return $this->render('incorrect', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}

	public function actionSend()
	{
		$model = new ChatForm();

		if ($model->load(\Yii::$app->request->post())) {
			if (!$model->saveMessage()) {
				\Yii::$app->session->setFlash('error', $model->getFirstError(''));
			}
			
			
			return $this->redirect(['index']);
		}
	}

	public function actionSetIncorrect($id)
	{
		$model = Message::findOne($id);

        if ($model === null) {
        	\Yii::$app->session->setFlash('error', 'Сообщение не найдено');
        	return $this->redirect(['index']);
        }

        if (!$model->setIncorrect()) {
        	\Yii::$app->session->setFlash('error', $model->getFirstErrors());
        	return $this->redirect(['index']);
        }

        return $this->redirect(['index']);
	}

	public function actionSetCorrect($id)
	{
		$model = Message::findOne($id);

        if ($model === null) {
        	\Yii::$app->session->setFlash('error', 'Сообщение не найдено');
        	return $this->redirect(['incorrect']);
        }

        if (!$model->setCorrect()) {
        	\Yii::$app->session->setFlash('error', $model->getFirstErrors());
        	return $this->redirect(['incorrect']);
        }

        return $this->redirect(['incorrect']);
	}
}