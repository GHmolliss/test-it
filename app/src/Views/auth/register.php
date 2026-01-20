<?php
/** @var RegisterForm $model */
?>

<h1>Регистрация</h1>

<?php $form = $this->beginWidget('CActiveForm', [
    'id' => 'register-form',
    'enableClientValidation' => true,
]); ?>

<?php echo $form->errorSummary($model); ?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'name'); ?>
    <?php echo $form->textField($model, 'name'); ?>
    <?php echo $form->error($model, 'name'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'phone'); ?>
    <?php echo $form->textField($model, 'phone', ['placeholder' => '+7 9XX XXX XX XX']); ?>
    <?php echo $form->error($model, 'phone'); ?>
    <small>Мобильный номер с кодом оператора 900-999</small>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'password'); ?>
    <?php echo $form->passwordField($model, 'password'); ?>
    <?php echo $form->error($model, 'password'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'password_confirm'); ?>
    <?php echo $form->passwordField($model, 'password_confirm'); ?>
    <?php echo $form->error($model, 'password_confirm'); ?>
</div>

<div class="form-group">
    <?php echo CHtml::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary']); ?>
</div>

<?php $this->endWidget(); ?>

<p>Уже есть аккаунт? <?php echo CHtml::link('Войти', ['auth/login']); ?></p>
