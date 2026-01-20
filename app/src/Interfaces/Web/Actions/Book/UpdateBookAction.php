<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Actions\Book;

use App\Interfaces\Web\Actions\AbstractAction;
use App\Interfaces\Web\Actions\EntityLoaderTrait;
use App\Interfaces\Web\Requests\Book\UpdateBookRequest;
use AuthorService;
use Book;
use BookForm;
use BookService;
use CController;
use CException;

class UpdateBookAction extends AbstractAction
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

        /** @var AuthorService $authorService */
        $authorService = $this->getService(AuthorService::class);

        /** @var Book $book */
        $book = $this->loadEntity(
            Book::class,
            $this->id,
            'Книга не найдена',
            ['authors']
        );

        // Форма для рендеринга
        $form = new BookForm();
        $form->loadFromModel($book);

        if ($this->isPost()) {
            $postData = $this->getPostData('BookForm');
            $request = UpdateBookRequest::fromPostWithBook($postData, $book);

            // Синхронизируем форму с request для отображения
            $form->attributes = $postData;

            if ($request->validate()) {
                try {
                    $bookService->update(
                        $book,
                        $request->toArray(),
                        $request->getAuthorIds(),
                        $request->getCoverFile()
                    );

                    $this->setFlash('success', 'Книга успешно обновлена');
                    $this->redirect(['book/view', 'id' => $book->id]);
                    return;
                } catch (CException $e) {
                    $this->setFlash('error', $e->getMessage());
                }
            } else {
                // Переносим ошибки из Request в Form
                $this->transferErrors($request, $form);
            }
        }

        $this->render('form', [
            'model' => $form,
            'book' => $book,
            'authors' => $authorService->getListData(),
        ]);
    }

    /**
     * Перенос ошибок из Request DTO в Form для отображения
     */
    private function transferErrors(UpdateBookRequest $request, BookForm $form): void
    {
        foreach ($request->getErrors() as $attribute => $errors) {
            foreach ($errors as $error) {
                $form->addError($attribute, $error);
            }
        }
    }
}
