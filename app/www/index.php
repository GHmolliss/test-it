<?php

declare(strict_types=1);

require_once dirname(__FILE__) . '/../src/vendor/autoload.php';

$yii = dirname(__FILE__) . '/../src/vendor/yiisoft/yii/framework/yii.php';
$config = dirname(__FILE__) . '/../src/Config/main.php';

require_once($yii);

Yii::createWebApplication($config)->run();
