<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Actions\Site;

use App\Interfaces\Web\Actions\AbstractAction;
use BookService;

/**
 * Action для главной страницы
 */
class IndexAction extends AbstractAction
{
    public function run(): void
    {
        $bookService = $this->getService(BookService::class);
        $dataProvider = $bookService->getDataProvider();

        $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
