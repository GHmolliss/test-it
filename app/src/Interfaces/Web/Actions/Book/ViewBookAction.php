<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Actions\Book;

use App\Interfaces\Web\Actions\AbstractAction;
use App\Interfaces\Web\Actions\EntityLoaderTrait;
use Book;
use BookService;
use CController;

/**
 * Action для просмотра одной книги
 */
class ViewBookAction extends AbstractAction
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
        $book = $this->loadEntity(
            Book::class,
            $this->id,
            'Книга не найдена',
            ['authors']
        );

        $this->render('view', [
            'book' => $book,
        ]);
    }
}
