<?php
/** @var Book $data */
?>

<div style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 4px;">
    <h3><?php echo CHtml::link(CHtml::encode($data->title), ['book/view', 'id' => $data->id]); ?></h3>
    <p><strong>Год:</strong> <?php echo $data->year; ?></p>
    <p><strong>Авторы:</strong> <?php echo CHtml::encode($data->getAuthorsString()); ?></p>
    <?php if ($data->isbn): ?>
        <p><strong>ISBN:</strong> <?php echo CHtml::encode($data->isbn); ?></p>
    <?php endif; ?>
</div>
