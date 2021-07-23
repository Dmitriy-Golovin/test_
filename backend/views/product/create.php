<?php

use yii\helpers\Html;

$this->title = 'Добавить товар';
?>

<div class="create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('form', [
        'model' => $model,
    ]) ?>

</div>