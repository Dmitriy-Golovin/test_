<?php
namespace backend\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\MessageForm;
use common\models\User;
use common\models\Message;

class MessageController extends Controller
{
	public function behaviors()
	{
        $behaviors = [];

		$behaviors['access'] = [
			'class' => \yii\filters\AccessControl::className(),
			'rules' => [
				[
					'allow' => true,
					'actions' => ['correct', 'incorrect', 'set-incorrect', 'set-correct'],
					'roles' => ['admin'],
				],
			],
		];

        return $behaviors;
	}

	public function actionCorrect()
	{
		$searchModel = new MessageForm();

        $dataProvider = $searchModel->searchCorrect(\Yii::$app->request->queryParams);

        return $this->render('correct', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}

	public function actionIncorrect()
	{
        $searchModel = new MessageForm();

        $dataProvider = $searchModel->searchIncorrect(\Yii::$app->request->queryParams);

        return $this->render('incorrect', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}

	public function actionSetIncorrect($id)
	{
		$model = Message::findOne($id);

        if ($model === null) {
        	\Yii::$app->session->setFlash('error', 'Сообщение не найдено');
        	return $this->redirect(['correct']);
        }

        if (!$model->setIncorrect()) {
        	\Yii::$app->session->setFlash('error', $model->getFirstErrors());
        	return $this->redirect(['correct']);
        }

        return $this->redirect(['correct']);
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