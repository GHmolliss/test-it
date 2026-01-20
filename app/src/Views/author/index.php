<?php
/** @var CActiveDataProvider $dataProvider */
?>

<h1>Авторы</h1>

<?php if (!Yii::app()->user->isGuest): ?>
    <div class="actions">
        <?php echo CHtml::link('Добавить автора', ['author/create'], ['class' => 'btn btn-primary']); ?>
    </div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>ФИО</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dataProvider->getData() as $author): ?>
            <tr>
                <td><?php echo CHtml::link(CHtml::encode($author->full_name), ['author/view', 'id' => $author->id]); ?></td>
                <td>
                    <?php echo CHtml::link('Просмотр', ['author/view', 'id' => $author->id], ['class' => 'btn btn-primary']); ?>
                    <?php if (Yii::app()->user->isGuest): ?>
                        <?php echo CHtml::link('Подписаться', ['subscription/subscribe', 'id' => $author->id], ['class' => 'btn btn-success']); ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php $this->widget('CLinkPager', ['pages' => $dataProvider->pagination]); ?>
