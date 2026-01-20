<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Actions\Site;

use App\Interfaces\Web\Actions\AbstractAction;
use Yii;

class ErrorAction extends AbstractAction
{
    public function run(): void
    {
        $error = Yii::app()->errorHandler->error;

        if ($error) {
            $this->render('error', ['error' => $error]);
        }
    }
}
