<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;
use yii\helpers\Html;
use common\models\Message;

$this->title = 'Некорректные сообщения';
$this->params['breadcrumbs'][] = $this->title;
?>

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
            'setCorrect' => function($url, Message $model) {
                return Html::a('<span class="glyphicon glyphicon-ok"></span>', [
                    'message/set-correct', 'id' => $model->messageId,
                ]);
            },
        ],
        'template'=>'{setCorrect}'
    ],
];
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumn,
    'summary' => false,
]); ?>