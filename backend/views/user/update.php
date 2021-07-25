<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\models\User;

$this->title = !empty($model->username) ? 'Редактировать пользователя ' . $model->username : 'Редактировать пользователя';

$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['user/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-update">

	<?php $form = ActiveForm::begin(); ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $form->field($model, 'role')->dropDownList($model->roleLabels()); ?>

    <div class="form-group">
        <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>