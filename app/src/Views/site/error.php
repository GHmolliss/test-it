<?php
/** @var array $error */
?>

<h1>Ошибка <?php echo $error['code']; ?></h1>
<p><?php echo CHtml::encode($error['message']); ?></p>
<p><?php echo CHtml::link('На главную', ['/']); ?></p>
