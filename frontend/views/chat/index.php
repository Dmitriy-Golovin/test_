<?php

/* @var $this yii\web\View */
/* @var $model frontend\models\ChatForm */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Message;
use common\models\User;

$this->title = 'Чат';

var_dump(\Yii::$app->authManager->getRolesByUser(9));
?>

<div class="chat-index">
	<?php Pjax::begin(['id' => 'my_pjax']); ?>

	<div class="<?= (\Yii::$app->user->can('user') || \Yii::$app->user->can('admin')) ? 'message-block' : 'guest-message-block' ?>">
		<?php
		foreach($dataProvider->getModels() as $message) {
			$buttonSetIncorrect = ($message->correct == Message::CORRECT && \Yii::$app->user->can('admin')) ?
				Html::a('Пометить некорректным', ['set-incorrect', 'id' => $message->messageId], ['class' => 'btn-set-incorrect btn btn-primary',
		            'data' => [
		                'method' => 'post',
		            ],
	        	]) : '';

			$incorrectMessageEl = ($message->correct == Message::INCORRECT) ? Html::tag('span', 'Некорректное сообщение', ['class' => 'incorrect-message-block']) : '';

			echo Html::tag('div', 
				Html::tag('div',
					Html::tag('span', $message->user->username, ['class' => 'message-username']) . ' ' .
					Html::tag('span', Html::encode(\Yii::$app->formatter->asDatetime($message->createdAt)), ['class' => 'message-time']),
				['class' => 'message-title']) . ' ' .
				Html::tag('div', Html::encode($message->text), ['class' => 'message-content']) . ' ' .
				$buttonSetIncorrect . ' ' .
				$incorrectMessageEl,
			['class' => !empty(\Yii::$app->authManager->getRolesByUser($message->userId)[User::ROLE_ADMIN]) ? 'message-container message-admin-container' : 'message-container']);
		}
		?>

	</div>
	<div class="<?= (\Yii::$app->user->can('user') || \Yii::$app->user->can('admin')) ? 'write-message-block' : 'guest-write-message-block' ?>">
		<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'text')->textArea([
			'rows' => '5',
			'placeHolder' => 'Введите сообщение',
		])->label(false) ?>

		<div class="form-group">
	        <?= Html::a('Отправить', ['chat/send'], [
	        	'class' => 'btn btn-success',
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
	if ($('.message-block') && $('.message-block')[0]) {
		$('.message-block').scrollTop($('.message-block')[0].scrollHeight);
	}

	if ($('.guest-message-block') && $('.guest-message-block')[0]) {
		$('.guest-message-block').scrollTop($('.guest-message-block')[0].scrollHeight);
	}
");

?>
