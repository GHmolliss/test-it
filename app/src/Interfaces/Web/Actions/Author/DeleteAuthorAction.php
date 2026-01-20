<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Actions\Author;

use App\Interfaces\Web\Actions\AbstractAction;
use App\Interfaces\Web\Actions\EntityLoaderTrait;
use Author;
use AuthorService;
use CController;

class DeleteAuthorAction extends AbstractAction
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

        $authorService = $this->getService(AuthorService::class);

        /** @var Author $author */
        $author = $this->loadEntity(
            Author::class,
            $this->id,
            'Автор не найден'
        );

        $authorService->delete($author);

        $this->setFlash('success', 'Автор удалён');
        $this->redirect(['author/index']);
    }
}
