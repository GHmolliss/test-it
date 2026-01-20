<?php
/** @var BookForm $model */
/** @var array $authors */
/** @var Book|null $book */
$isNew = !isset($book);
?>

<h1><?php echo $isNew ? 'Добавить книгу' : 'Редактировать книгу'; ?></h1>

<?php $form = $this->beginWidget('CActiveForm', [
    'id' => 'book-form',
    'enableClientValidation' => true,
    'htmlOptions' => ['enctype' => 'multipart/form-data'],
]); ?>

<?php echo $form->errorSummary($model); ?>

<div class="form-group">
    <?php echo $form->labelEx($model, 'title'); ?>
    <?php echo $form->textField($model, 'title'); ?>
    <?php echo $form->error($model, 'title'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'year'); ?>
    <?php echo $form->textField($model, 'year', ['type' => 'number', 'min' => 1000, 'max' => 2100]); ?>
    <?php echo $form->error($model, 'year'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'author_ids'); ?>
    <?php echo $form->listBox($model, 'author_ids', $authors, ['multiple' => true, 'size' => 5]); ?>
    <?php echo $form->error($model, 'author_ids'); ?>
    <small>Удерживайте Ctrl для выбора нескольких авторов</small>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'isbn'); ?>
    <?php echo $form->textField($model, 'isbn'); ?>
    <?php echo $form->error($model, 'isbn'); ?>
</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'description'); ?>
    <?php echo $form->textArea($model, 'description'); ?>
    <?php echo $form->error($model, 'description'); ?>
</div>

<div class="form-group">
    <label>Обложка</label>
    <?php echo CHtml::activeFileField($model, 'cover_image'); ?>
    <?php if (!$isNew && $book->cover_image): ?>
        <p>Текущая: <img src="<?php echo $book->getCoverUrl(); ?>" alt="" style="max-width: 100px;"></p>
    <?php endif; ?>
</div>

<div class="form-group">
    <?php echo CHtml::submitButton($isNew ? 'Добавить' : 'Сохранить', ['class' => 'btn btn-primary']); ?>
    <?php echo CHtml::link('Отмена', ['book/index'], ['class' => 'btn']); ?>
</div>

<?php $this->endWidget(); ?>
