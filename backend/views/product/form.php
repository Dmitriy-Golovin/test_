<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\widgets\MaskedInput;

?>

<div class="city-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=$form->field($model, 'image')->fileInput()->label('Изображение товара') ?>

    <?= $form->field($model, 'SKU')->textInput() ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'amount')->widget(MaskedInput::className(), [
        'mask' => '9',
        'clientOptions' => ['repeat' => 10, 'greedy' => false]
    ]) ?>

    <?= $form->field($model, 'type')->dropDownList($model->typeLabels()); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>