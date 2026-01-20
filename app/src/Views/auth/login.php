<?php
/** @var LoginForm $model */
?>

<h1>Вход</h1>

<?php $form = $this->beginWidget('CActiveForm', [
    'id' => 'login-form',
    'enableClientValidation' => true,
]); ?>

<?php echo $form->errorSummary($model); ?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'phone'); ?>
    <?php echo $form->textField($model, 'phone', ['placeholder' => '+7 9XX XXX XX XX']); ?>
    <?php echo $form->error($model, 'phone'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'password'); ?>
    <?php echo $form->passwordField($model, 'password'); ?>
    <?php echo $form->error($model, 'password'); ?>
</div>

<div class="form-group">
    <?php echo CHtml::submitButton('Войти', ['class' => 'btn btn-primary']); ?>
</div>

<?php $this->endWidget(); ?>

<p>Нет аккаунта? <?php echo CHtml::link('Зарегистрироваться', ['auth/register']); ?></p>
