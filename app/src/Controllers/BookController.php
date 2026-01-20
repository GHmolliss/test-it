<?php

declare(strict_types=1);

use App\Interfaces\Web\Actions\Book\CreateBookAction;
use App\Interfaces\Web\Actions\Book\DeleteBookAction;
use App\Interfaces\Web\Actions\Book\ListBooksAction;
use App\Interfaces\Web\Actions\Book\UpdateBookAction;
use App\Interfaces\Web\Actions\Book\ViewBookAction;

class BookController extends Controller
{
    public function actionIndex(): void
    {
        $action = new ListBooksAction($this);
        $action->run();
    }

    public function actionView(int $id): void
    {
        $action = new ViewBookAction($this, $id);
        $action->run();
    }

    public function actionCreate(): void
    {
        $action = new CreateBookAction($this);
        $action->run();
    }

    public function actionUpdate(int $id): void
    {
        $action = new UpdateBookAction($this, $id);
        $action->run();
    }

    public function actionDelete(int $id): void
    {
        $action = new DeleteBookAction($this, $id);
        $action->run();
    }
}
