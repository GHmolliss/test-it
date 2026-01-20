<?php
/** @var CActiveDataProvider $dataProvider */
?>

<h1>Книги</h1>

<?php if (!Yii::app()->user->isGuest): ?>
    <div class="actions">
        <?php echo CHtml::link('Добавить книгу', ['book/create'], ['class' => 'btn btn-primary']); ?>
    </div>
<?php endif; ?>

<?php $this->widget('zii.widgets.CListView', [
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
    'emptyText' => 'Книги не найдены',
    'template' => '{items}{pager}',
]); ?>
