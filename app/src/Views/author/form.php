<?php
/** @var AuthorForm $model */
/** @var Author|null $author */
$isNew = !isset($author);
?>

<h1><?php echo $isNew ? 'Добавить автора' : 'Редактировать автора'; ?></h1>

<?php $form = $this->beginWidget('CActiveForm', [
    'id' => 'author-form',
    'enableClientValidation' => true,
]); ?>

<?php echo $form->errorSummary($model); ?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'full_name'); ?>
    <?php echo $form->textField($model, 'full_name'); ?>
    <?php echo $form->error($model, 'full_name'); ?>
</div>

<div class="form-group">
    <?php echo CHtml::submitButton($isNew ? 'Добавить' : 'Сохранить', ['class' => 'btn btn-primary']); ?>
    <?php echo CHtml::link('Отмена', ['author/index'], ['class' => 'btn']); ?>
</div>

<?php $this->endWidget(); ?>
