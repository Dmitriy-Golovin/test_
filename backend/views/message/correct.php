<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Html;
use common\models\Message;

$this->title = 'Корректные сообщения';
$this->params['breadcrumbs'][] = $this->title;

$user = \Yii::$app->user->identity;
?>

<?php Pjax::begin(['id' => 'my_pjax']); ?>

<?php
$gridColumn = [
    'messageId',
    [
        'attribute' => 'author',
        'value' => function(Message $model) {
            $authorUsername = $model->user->username;
            return !empty($authorUsername) ? $authorUsername : '';
        }
    ],
    'text',
    'createdAt:datetime',
    [
        'class' => 'yii\grid\ActionColumn',
        'contentOptions' => ['style' => 'min-width: 8%;'],

        'buttons' => [
            'setIncorrect' => function($url, Message $model) {
                return Html::a('<span class="glyphicon glyphicon-remove"></span>', [
                    'message/set-incorrect', 'id' => $model->messageId,
                    'pjax-container' => 'my_pjax',
                ]);
            },
        ],
        'template'=>'{setIncorrect}'
    ],
];
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumn,
    'summary' => false,
]); ?>
<?php Pjax::end(); ?>

