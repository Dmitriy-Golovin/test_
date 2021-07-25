<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveField;
use common\models\User;

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

$user = \Yii::$app->user->identity;
?>

<?php Pjax::begin(['id' => 'my_pjax']); ?>

<?php
$gridColumn = [
    'userId',
    'username',
    'email',
    [
    	'attribute' => 'role',
    	'value' => function(User $model) {
    		return !empty($model->role) ? User::roleLabels()[$model->role] : null;
    	}
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'contentOptions' => ['style' => 'min-width: 8%;'],

        'buttons' => [
            'update' => function($url, $searchModel) use ($user) {
                if ($searchModel->userId !== $user->userId) {
                	return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['user/update', 'id' => $searchModel->userId]);
                }
            },
        ],
        'template'=>'{update}'
    ],
];
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumn,
    'summary' => false,
]); ?>
<?php Pjax::end(); ?>

