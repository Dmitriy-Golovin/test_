<?php

use yii\helpers\Html;

$this->title = 'Редактировать товар';
?>

<div class="update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('form', [
        'model' => $model,
    ]) ?>

</div>