<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use common\models\User;

$this->title = 'Пользователи';

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
    		return $model->roleLabels()[User::getUserRole($model->userId)];
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

