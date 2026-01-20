<?php
/** @var SubscriptionForm $model */
/** @var Author $author */
?>

<h1>Подписка на автора</h1>

<p>Вы подписываетесь на уведомления о новых книгах автора <strong><?php echo CHtml::encode($author->full_name); ?></strong>.</p>

<?php $form = $this->beginWidget('CActiveForm', [
    'id' => 'subscription-form',
    'enableClientValidation' => true,
]); ?>

<?php echo $form->errorSummary($model); ?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'phone'); ?>
    <?php echo $form->textField($model, 'phone', ['placeholder' => '+7 9XX XXX XX XX']); ?>
    <?php echo $form->error($model, 'phone'); ?>
    <small>Введите мобильный номер (код оператора 900-999) для получения SMS-уведомлений</small>
</div>

<div class="form-group">
    <?php echo CHtml::submitButton('Подписаться', ['class' => 'btn btn-success']); ?>
    <?php echo CHtml::link('Отмена', ['author/view', 'id' => $author->id], ['class' => 'btn']); ?>
</div>

<?php $this->endWidget(); ?>
