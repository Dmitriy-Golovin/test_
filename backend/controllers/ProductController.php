<?php
namespace backend\controllers;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\ProductForm;
use common\models\Product;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

class ProductController extends Controller
{
	public function behaviors()
	{
        $behaviors = [];

		$behaviors['access'] = [
			'class' => \yii\filters\AccessControl::className(),
			'rules' => [

				[
					'allow' => false,
					'roles' => ['?'],
				],

				[
					'allow' => true,
					'roles' => ['@'],
				],
			],
		];

        return $behaviors;
	}

	public function actionIndex()
	{
		$formModel = new ProductForm();

        if (\Yii::$app->request->isPost) {
            //print_r(\Yii::$app->request->post());die;
        	$formModel->load(\Yii::$app->request->post());
        }

        $dataProvider = $formModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'formModel' => $formModel,
            'dataProvider' => $dataProvider,
        ]);
	}

	public function actionCreate()
    {
        $model = new Product();
        return $this->saveProduct($model,'create');
    }

    public function actionUpdate($id)
    {
        $model = Product::findOne([$id]);

        if (empty($model)) {
        	throw new NotFoundHttpException('Товара не существет');
        }

        return $this->saveProduct($model,'update');
    }

    public function actionDeleteItemList()
    {
        if (\Yii::$app->request->isPost) {
            $idList = json_decode(\Yii::$app->request->getBodyParam('idList'));

            if (!empty($idList)) {
                foreach ($idList as $id) {
                    $product = Product::findOne($id);
                    if (!empty($id)) {
                        $product->delete();
                    }
                }
            }

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => true, 'idListForDelete' => $idList];
        }
    }

    public function actionSelectColumn()
    {
        if (\Yii::$app->request->isPost) {
            $columnData = json_decode(\Yii::$app->request->getBodyParam('columnData'));
            $formModel = new ProductForm();
            $formModel->load(ArrayHelper::toArray($columnData, []));
            //print_r(ArrayHelper::toArray($columnData, []));die;

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['ee' => $formModel->imagePathColumn];
            //return ['success' => true];
        }
    }

    public function saveProduct($model, string $view)
    {
        if (\Yii::$app->request->isGet) {
            return $this->render($view, [
                'model' => $model,
            ]);
        }

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
        	$image = UploadedFile::getInstance($model, 'image');
        	$uploadDir = $model->getUploadDir();

        	$db = \Yii::$app->db;
			$transaction = $db->beginTransaction();

			if (!empty($image)) {
	        	$imageName = \Yii::$app->security->generateRandomString() . '.' . $image->extension;
				$imagePath = $uploadDir . '/' . $imageName;

	        	

				if (!$image->saveAs($imagePath)) {
					$transaction->rollBack();
	                $this->getViewError($model, $view);
				}

				$model->imagePath = \Yii::getAlias('@uploadsImg') . '/' . $imageName;
			}

            if (!$model->save()) {
                /*\Yii::$app->session->setFlash('error', $model->getFirstErrors());
                \Yii::error($model->getFirstErrors());
                return $this->render($view, ['model' => $model]);*/
                $this->getViewError($model, $view);
            }

			$transaction->commit();
            return $this->redirect(['index']);
        }

        if ($model->hasErrors()) {
        	\Yii::$app->session->setFlash('error', $model->getFirstErrors());
        }


        \Yii::error($model->getFirstErrors());
        return $this->render($view, [
            'model' => $model,
        ]);
    }

    private function getViewError($model, $view)
    {
    	\Yii::$app->session->setFlash('error', $model->getFirstErrors());
        \Yii::error($model->getFirstErrors());
        return $this->render($view, ['model' => $model]);
    }
}