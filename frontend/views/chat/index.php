<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Message;
use common\models\User;

$this->title = 'Чат';
$this->params['breadcrumbs'][] = $this->title;

$user = \Yii::$app->user->identity;
?>

<div class="chat-index">
	<?php Pjax::begin(['id' => 'my_pjax']); ?>

	<div class="<?= ($user->isGuest()) ? 'guest-message-block' : 'message-block' ?>">
		<?php
		foreach($queryMessage->each() as $message) {
			$incorrectMessageEl = ($message->correct == Message::INCORRECT) ? Html::tag('span', 'Некорректное сообщение', ['class' => 'incorrect-message-block']) : '';

			echo Html::tag('div', 
			Html::tag('div',
				Html::tag('span', $message->user->username, ['class' => 'message-username']) . ' ' .
				Html::tag('span', Html::encode(\Yii::$app->formatter->asDatetime($message->createdAt)), ['class' => 'message-time']),
			['class' => 'message-title']) . ' ' .
			Html::tag('div', Html::encode($message->text), ['class' => 'message-content']) . ' ' .
			$incorrectMessageEl,
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

<?php

$this->registerJs("
	let messageBlock = $('.message-block'),
		guestMessageBlock = $('.guest-message-block');

	if ($('.message-block') && $('.message-block')[0]) {
		$('.message-block').scrollTop($('.message-block')[0].scrollHeight);
	}

	if ($('.guest-message-block') && $('.guest-message-block')[0]) {
		$('.guest-message-block').scrollTop($('.guest-message-block')[0].scrollHeight);
	}
");

?>
