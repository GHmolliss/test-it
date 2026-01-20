<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Actions\Author;

use App\Interfaces\Web\Actions\AbstractAction;
use AuthorService;

/**
 * Action для отображения списка авторов
 */
class ListAuthorsAction extends AbstractAction
{
    public function run(): void
    {
        $authorService = $this->getService(AuthorService::class);
        
        $dataProvider = $authorService->getDataProvider();
        
        $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
