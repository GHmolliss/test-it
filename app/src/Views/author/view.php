<?php
/** @var Author $author */
?>

<h1><?php echo CHtml::encode($author->full_name); ?></h1>

<?php if (Yii::app()->user->isGuest): ?>
    <div class="actions">
        <?php echo CHtml::link('Подписаться на новые книги', ['subscription/subscribe', 'id' => $author->id], ['class' => 'btn btn-success']); ?>
    </div>
<?php else: ?>
    <div class="actions">
        <?php echo CHtml::link('Редактировать', ['author/update', 'id' => $author->id], ['class' => 'btn btn-primary']); ?>
        <?php echo CHtml::link('Удалить', ['author/delete', 'id' => $author->id], [
            'class' => 'btn btn-danger',
            'confirm' => 'Вы уверены, что хотите удалить этого автора?',
        ]); ?>
    </div>
<?php endif; ?>

<h2>Книги автора</h2>

<?php if ($author->books): ?>
    <ul>
        <?php foreach ($author->books as $book): ?>
            <li>
                <?php echo CHtml::link(CHtml::encode($book->title), ['book/view', 'id' => $book->id]); ?>
                (<?php echo $book->year; ?>)
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>У этого автора пока нет книг.</p>
<?php endif; ?>

<p style="margin-top: 20px;"><?php echo CHtml::link('← К списку авторов', ['author/index']); ?></p>
