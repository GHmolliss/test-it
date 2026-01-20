<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Actions\Book;

use App\Interfaces\Web\Actions\AbstractAction;
use App\Interfaces\Web\Actions\EntityLoaderTrait;
use Book;
use BookService;
use CController;

class DeleteBookAction extends AbstractAction
{
    use EntityLoaderTrait;

    private int $id;

    public function __construct(CController $controller, int $id)
    {
        parent::__construct($controller);
        $this->id = $id;
    }

    public function run(): void
    {
        $this->requireUser();

        /** @var BookService $bookService */
        $bookService = $this->getService(BookService::class);

        /** @var Book $book */
        $book = $this->loadEntity(
            Book::class,
            $this->id,
            'Книга не найдена'
        );

        $bookService->delete($book);

        $this->setFlash('success', 'Книга удалена');
        $this->redirect(['book/index']);
    }
}
