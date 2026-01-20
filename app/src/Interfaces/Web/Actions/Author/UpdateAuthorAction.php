<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Actions\Author;

use App\Interfaces\Web\Actions\AbstractAction;
use App\Interfaces\Web\Actions\EntityLoaderTrait;
use App\Interfaces\Web\Requests\Author\UpdateAuthorRequest;
use Author;
use AuthorForm;
use AuthorService;
use CController;
use CException;

/**
 * Action для обновления автора
 */
class UpdateAuthorAction extends AbstractAction
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

        $form = new AuthorForm();
        $form->loadFromModel($author);

        if ($this->isPost()) {
            $postData = $this->getPostData('AuthorForm');
            $request = UpdateAuthorRequest::fromPostWithAuthor($postData, $author);

            $form->attributes = $postData;

            if ($request->validate()) {
                try {
                    $authorService->update($author, $request->toArray());
                    
                    $this->setFlash('success', 'Автор успешно обновлён');
                    $this->redirect(['author/view', 'id' => $author->id]);
                    return;
                } catch (CException $e) {
                    $this->setFlash('error', $e->getMessage());
                }
            } else {
                $this->transferErrors($request, $form);
            }
        }

        $this->render('form', [
            'model' => $form,
            'author' => $author,
        ]);
    }

    private function transferErrors(UpdateAuthorRequest $request, AuthorForm $form): void
    {
        foreach ($request->getErrors() as $attribute => $errors) {
            foreach ($errors as $error) {
                $form->addError($attribute, $error);
            }
        }
    }
}
