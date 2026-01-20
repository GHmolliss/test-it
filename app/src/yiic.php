<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

$yii = __DIR__ . '/vendor/yiisoft/yii/framework/yii.php';
$config = __DIR__ . '/Config/console.php';

require_once $yii;

Yii::createConsoleApplication($config)->run();
