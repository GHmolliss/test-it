<?php

declare(strict_types=1);

use App\Interfaces\Web\Actions\Author\CreateAuthorAction;
use App\Interfaces\Web\Actions\Author\DeleteAuthorAction;
use App\Interfaces\Web\Actions\Author\ListAuthorsAction;
use App\Interfaces\Web\Actions\Author\UpdateAuthorAction;
use App\Interfaces\Web\Actions\Author\ViewAuthorAction;

class AuthorController extends Controller
{
    public function actionIndex(): void
    {
        $action = new ListAuthorsAction($this);
        $action->run();
    }

    public function actionView(int $id): void
    {
        $action = new ViewAuthorAction($this, $id);
        $action->run();
    }

    public function actionCreate(): void
    {
        $action = new CreateAuthorAction($this);
        $action->run();
    }

    public function actionUpdate(int $id): void
    {
        $action = new UpdateAuthorAction($this, $id);
        $action->run();
    }

    public function actionDelete(int $id): void
    {
        $action = new DeleteAuthorAction($this, $id);
        $action->run();
    }
}
