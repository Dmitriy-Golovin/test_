<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use common\models\Product;

?>

<p>
    <?= Html::a('Добавить', ['product/create'], ['class' => 'btn btn-success']) ?>
    <?= Html::button('Удалить выбранные', ['class' => 'btn btn-danger', 'id' => 'delete_item_list']) ?>
</p>

<?php $form = ActiveForm::begin(); ?>

<div class="container" style="max-width: 100%; padding: 10px 0 0 0; border-top: 1px solid green; border-bottom: 1px solid green">
    <div class="row" style="margin-right: 0 ">

        <div class="col-sm-2"><?= $form->field($formModel, 'imagePathColumn')->checkbox([]); ?></div>

        <div class="col-sm-2"><?= $form->field($formModel, 'SKUColumn')->checkbox([]); ?></div>

        <div class="col-sm-2"><?= $form->field($formModel, 'nameColumn')->checkbox([]); ?></div>

        <div class="col-sm-2"><?= $form->field($formModel, 'amountColumn')->checkbox([]); ?></div>

        <div class="col-sm-2"><?= $form->field($formModel, 'typeColumn')->checkbox([]); ?></div>

        <div class="form-group" style="float:right">
            <?= Html::submitButton('Показать колонки', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>

<?php Pjax::begin(['id' => 'my_pjax']); ?>

<?php
echo $form->field($formModel, 'searchString', [
        'template' => '<div class="input-group">{input}<span class="input-group-btn">' .
        Html::submitButton('GO', ['class' => 'btn btn-primary']) .
        '</span></div>',
    ])->textInput(['placeholder' => 'Поиск']);
?>

<?php
$gridColumn = [
	[
        'attribute' => 'imagePath',
        'format' => 'raw',
        'visible' => ($formModel->imagePathColumn == null) ? 1 : $formModel->imagePathColumn,
        'value' => function (Product $model) {
            if (!empty($model->imagePath)) {
                return Html::img($model->imagePath, ['class' => 'previewImage']);
            }
        }
    ],
    [
        'attribute' => 'SKU',
        'format' => 'raw',
        'visible' => ($formModel->imagePathColumn == null) ? 1 : $formModel->SKUColumn,
    ],
    [
        'attribute' => 'name',
        'format' => 'raw',
        'visible' => ($formModel->imagePathColumn == null) ? 1 : $formModel->nameColumn,
    ],
    [
        'attribute' => 'amount',
        'format' => 'raw',
        'visible' => ($formModel->imagePathColumn == null) ? 1 : $formModel->amountColumn,
    ],
    [
        'attribute' => 'type',
        'format' => 'raw',
        'visible' => ($formModel->imagePathColumn == null) ? 1 : $formModel->typeColumn,
        'value' =>function($model) {
            return $model->typeLabels()[$model->type];
        }
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'contentOptions' => ['style' => 'min-width: 8%;'],

        'buttons' => [
            'update' => function($url, $formModel) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['product/update', 'id' => $formModel->productId]);
            },
            'delete' => function ($url, $searchModel) {
                return Html::a('<i class="fas fa-trash-alt"></i>', false, [
                    'class' => 'pjax-delete-link',
                    'delete-url' => $url,
                    'title' => 'удалить'
                ]);
            }

        ],
        'template'=>'{delete} {update}'
    ],
    [
        'class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function($model) {
            return ['value' => $model->productId];
        },
        'contentOptions' => ['class' => 'checkbox_item_delete']
    ],
];
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $formModel,
    'columns' => $gridColumn,
    'summary' => false,
]); ?>
<?php Pjax::end(); ?>

<?php ActiveForm::end(); ?>

<?php

$this->registerJs("
    let deleteButton = $('#delete_item_list'),
        checkboxList = $('.checkbox_view_column');

    deleteButton.on('click', function() {
        let data = JSON.stringify(getIdListForDelete());
        
        $.ajax({
            url: '" . Url::toRoute(['product/delete-item-list']) . "',
            type: 'post',
            data: 'idList=' + data,
            success: function(data){
                $.pjax.reload('#my_pjax');

            },
            error: function () {
                
            }
        });
    });

    checkboxList.on('click', function() {
        let data = JSON.stringify({'ProductForm': getCheckboxState()}),
            form = $('form');
            form.submit();
        
        /*$.ajax({
            url: '" . Url::toRoute(['product/select-column']) . "',
            type: 'post',
            data: 'columnData=' + data,
            success: function(data){
                $.pjax.reload('#my_pjax');
            },
            error: function () {
                
            }
        });*/
    })

    function getIdListForDelete() {
        let checkboxDeleteList = $('.checkbox_item_delete').find('input'),
            result = [];

        for (let el of checkboxDeleteList) {
            if ($(el).is(':checked')) {
                result.push(el.value);
            }
        }

        return result;
    }

    function getCheckboxState() {
        let checkboxListState = $('.checkbox_view_column'),
            result = {};

        for (let i = 0; i < checkboxListState.length; i++) {
            let checked = 0;

            if ($(checkboxListState[i]).is(':checked')) {
                checked = 1;
            }

            result[checkboxListState[i].getAttribute('data-name')] = checked;
            //checkboxListState[i].value = checked;
        }

        return result;
    }
");

?>
