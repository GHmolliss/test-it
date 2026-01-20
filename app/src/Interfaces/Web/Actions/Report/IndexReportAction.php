<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Actions\Report;

use App\Interfaces\Web\Actions\AbstractAction;
use AuthorService;
use Yii;

/**
 * Action для отображения отчёта по топ-авторам
 */
class IndexReportAction extends AbstractAction
{
    public function run(): void
    {
        $authorService = $this->getService(AuthorService::class);

        $year = (int)(Yii::app()->request->getParam('year', date('Y')));
        $authors = $authorService->getTopAuthors($year);

        $years = range((int)date('Y'), 2000);

        $this->render('index', [
            'authors' => $authors,
            'year' => $year,
            'years' => array_combine($years, $years),
        ]);
    }
}
