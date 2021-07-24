<?php

use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use common\models\Message;
use common\models\User;

$user = Yii::$app->user->identity;
$queryMessage = Message::find();
?>

<div class="chat-index">
	<?php Pjax::begin(['id' => 'my_pjax']); ?>

	<div class="<?= ($user->isGuest()) ? 'guest-message-block' : 'message-block' ?>">
		<?php
		foreach($queryMessage->each() as $message) {
			echo Html::tag('div', 
			Html::tag('div',
				Html::tag('span', $message->user->username, ['class' => 'message-username']) . ' ' .
				Html::tag('span', Html::encode(\Yii::$app->formatter->asDatetime($message->createdAt)), ['class' => 'message-time']),
			['class' => 'message-title']) . ' ' .
			Html::tag('div', Html::encode($message->text), ['class' => 'message-content']),
			['class' => ($message->user->role == User::ROLE_ADMIN) ? 'message-container message-admin-container' : 'message-container']);
		}
		?>

	</div>
	<div class="<?= ($user->isGuest()) ? 'guest-write-message-block' : 'write-message-block' ?>">
		<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'text')->textArea([
			'rows' => '5',
			'placeHolder' => 'Введите сообщение',
		])->label(false) ?>

		<div class="form-group">
	        <?= Html::a('Отправить', ['chat/send'], [
	        	'class' => 'btn btn-success',
	        	'pjax-container' => 'my_pjax',
	        	'data' => [
                    'method' => 'post',
                ],
	        ]) ?>
	    </div>

		<?php ActiveForm::end(); ?>
	</div>

	<?php Pjax::end(); ?>

</div>
