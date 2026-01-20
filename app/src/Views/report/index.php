<?php
/** @var array $authors */
/** @var int $year */
/** @var array $years */
?>

<h1>ТОП-10 авторов за <?php echo $year; ?> год</h1>

<?php $form = $this->beginWidget('CActiveForm', [
    'method' => 'get',
    'action' => ['report/index'],
]); ?>

<div class="form-group" style="display: inline-flex; align-items: center; gap: 10px;">
    <label>Выберите год:</label>
    <?php echo CHtml::dropDownList('year', $year, $years); ?>
    <?php echo CHtml::submitButton('Показать', ['class' => 'btn btn-primary']); ?>
</div>

<?php $this->endWidget(); ?>

<?php if ($authors): ?>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Автор</th>
                <th>Количество книг</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($authors as $i => $author): ?>
                <tr>
                    <td><?php echo $i + 1; ?></td>
                    <td><?php echo CHtml::link(CHtml::encode($author['full_name']), ['author/view', 'id' => $author['id']]); ?></td>
                    <td><?php echo $author['books_count']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>За <?php echo $year; ?> год книги не найдены.</p>
<?php endif; ?>
