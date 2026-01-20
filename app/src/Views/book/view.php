<?php
/** @var Book $book */
?>

<h1><?php echo CHtml::encode($book->title); ?></h1>

<div style="display: flex; gap: 30px;">
    <?php if ($book->cover_image): ?>
        <div>
            <img src="<?php echo $book->getCoverUrl(); ?>" alt="Обложка" class="book-cover">
        </div>
    <?php endif; ?>

    <div>
        <p><strong>Год выпуска:</strong> <?php echo $book->year; ?></p>
        
        <p><strong>Авторы:</strong>
            <?php
            $authors = $book->authors;
            $lastAuthor = end($authors);
            foreach ($authors as $author): ?>
                <?php echo CHtml::link(CHtml::encode($author->full_name), ['author/view', 'id' => $author->id]); ?><?php echo $author !== $lastAuthor ? ', ' : ''; ?>
            <?php endforeach; ?>
        </p>

        <?php if ($book->isbn): ?>
            <p><strong>ISBN:</strong> <?php echo CHtml::encode($book->isbn); ?></p>
        <?php endif; ?>

        <?php if ($book->description): ?>
            <p><strong>Описание:</strong><br><?php echo nl2br(CHtml::encode($book->description)); ?></p>
        <?php endif; ?>

        <?php if (!Yii::app()->user->isGuest): ?>
            <div class="actions" style="margin-top: 20px;">
                <?php echo CHtml::link('Редактировать', ['book/update', 'id' => $book->id], ['class' => 'btn btn-primary']); ?>
                <?php echo CHtml::link('Удалить', ['book/delete', 'id' => $book->id], [
                    'class' => 'btn btn-danger',
                    'confirm' => 'Вы уверены, что хотите удалить эту книгу?',
                ]); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<p style="margin-top: 20px;"><?php echo CHtml::link('← К списку книг', ['book/index']); ?></p>
