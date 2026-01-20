<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Actions\Author;

use App\Interfaces\Web\Actions\AbstractAction;
use App\Interfaces\Web\Actions\EntityLoaderTrait;
use Author;
use CController;

class ViewAuthorAction extends AbstractAction
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
        $author = $this->loadEntity(
            Author::class,
            $this->id,
            'Автор не найден',
            ['books']
        );

        $this->render('view', [
            'author' => $author,
        ]);
    }
}
