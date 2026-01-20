<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Actions\Book;

use App\Interfaces\Web\Actions\AbstractAction;
use BookService;

class ListBooksAction extends AbstractAction
{
    public function run(): void
    {
        /** @var BookService $bookService */
        $bookService = $this->getService(BookService::class);

        $dataProvider = $bookService->getDataProvider();

        $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
