<?php

declare(strict_types=1);

use App\Interfaces\Web\Actions\Report\IndexReportAction;

class ReportController extends Controller
{
    public function actionIndex(): void
    {
        $action = new IndexReportAction($this);
        $action->run();
    }
}
