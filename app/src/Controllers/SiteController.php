<?php

declare(strict_types=1);

use App\Interfaces\Web\Actions\Site\ErrorAction;
use App\Interfaces\Web\Actions\Site\IndexAction;

class SiteController extends Controller
{
    public function actionIndex(): void
    {
        $action = new IndexAction($this);
        $action->run();
    }

    public function actionError(): void
    {
        $action = new ErrorAction($this);
        $action->run();
    }
}
