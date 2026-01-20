<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Actions\Author;

use App\Interfaces\Web\Actions\AbstractAction;
use App\Interfaces\Web\Requests\Author\CreateAuthorRequest;
use AuthorForm;
use AuthorService;
use CException;

/**
 * Action для создания автора
 */
class CreateAuthorAction extends AbstractAction
{
    public function run(): void
    {
        $this->requireUser();

        $authorService = $this->getService(AuthorService::class);

        $form = new AuthorForm();

        if ($this->isPost()) {
            $postData = $this->getPostData('AuthorForm');
            $request = CreateAuthorRequest::fromPost($postData);

            $form->attributes = $postData;

            if ($request->validate()) {
                try {
                    $authorService->create($request->toArray());
                    
                    $this->setFlash('success', 'Автор успешно добавлен');
                    $this->redirect(['author/index']);
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
        ]);
    }

    private function transferErrors(CreateAuthorRequest $request, AuthorForm $form): void
    {
        foreach ($request->getErrors() as $attribute => $errors) {
            foreach ($errors as $error) {
                $form->addError($attribute, $error);
            }
        }
    }
}
