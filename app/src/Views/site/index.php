<?php
/** @var CActiveDataProvider $dataProvider */
?>

<h1>Каталог книг</h1>

<?php if (!Yii::app()->user->isGuest): ?>
    <div class="actions">
        <?php echo CHtml::link('Добавить книгу', ['book/create'], ['class' => 'btn btn-primary']); ?>
        <?php echo CHtml::link('Добавить автора', ['author/create'], ['class' => 'btn btn-success']); ?>
    </div>
<?php endif; ?>

<?php $this->widget('zii.widgets.CListView', [
    'dataProvider' => $dataProvider,
    'itemView' => '/book/_item',
    'emptyText' => 'Книги не найдены',
    'template' => '{items}{pager}',
    'pager' => ['class' => 'CLinkPager'],
]); ?>
