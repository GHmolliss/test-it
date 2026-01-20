<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Actions\Book;

use App\Interfaces\Web\Actions\AbstractAction;
use App\Interfaces\Web\Requests\Book\CreateBookRequest;
use AuthorService;
use BookForm;
use BookService;
use CException;

/**
 * Action для создания книги
 */
class CreateBookAction extends AbstractAction
{
    public function run(): void
    {
        $this->requireUser();

        /** @var BookService $bookService */
        $bookService = $this->getService(BookService::class);
        
        /** @var AuthorService $authorService */
        $authorService = $this->getService(AuthorService::class);

        // Форма для рендеринга (Yii виджеты)
        $form = new BookForm();
        $request = null;

        if ($this->isPost()) {
            $postData = $this->getPostData('BookForm');
            $request = CreateBookRequest::fromPost($postData);

            // Синхронизируем форму с request для отображения ошибок
            $form->attributes = $postData;

            if ($request->validate()) {
                try {
                    $bookService->create(
                        $request->toArray(),
                        $request->getAuthorIds(),
                        $request->getCoverFile()
                    );
                    
                    $this->setFlash('success', 'Книга успешно добавлена');
                    $this->redirect(['book/index']);
                    return;
                } catch (CException $e) {
                    $this->setFlash('error', $e->getMessage());
                }
            } else {
                // Переносим ошибки из Request в Form для отображения
                $this->transferErrors($request, $form);
            }
        }

        $this->render('form', [
            'model' => $form,
            'authors' => $authorService->getListData(),
        ]);
    }

    /**
     * Перенос ошибок из Request DTO в Form для отображения
     */
    private function transferErrors(CreateBookRequest $request, BookForm $form): void
    {
        foreach ($request->getErrors() as $attribute => $errors) {
            foreach ($errors as $error) {
                $form->addError($attribute, $error);
            }
        }
    }
}
