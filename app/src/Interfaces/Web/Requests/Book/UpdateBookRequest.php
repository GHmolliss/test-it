<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Requests\Book;

use Book;
use CUploadedFile;

/**
 * Request DTO для обновления книги
 */
class UpdateBookRequest extends CreateBookRequest
{
    private ?Book $book = null;

    /**
     * Создание из POST-данных с привязкой к существующей книге
     * 
     * @param array<string, mixed> $data POST-данные формы
     * @param Book $book Существующая книга
     * @param string $formName Имя формы для получения файла
     */
    public static function fromPostWithBook(array $data, Book $book, string $formName = 'BookForm'): self
    {
        /** @var self $request */
        $request = self::fromPost($data, $formName);
        $request->book = $book;

        return $request;
    }

    /**
     * Заполнение данными из существующей книги (для отображения формы)
     */
    public static function fromBook(Book $book): self
    {
        $request = new self();
        
        $request->book = $book;
        $request->title = $book->title;
        $request->year = $book->year;
        $request->description = $book->description ?? '';
        $request->isbn = $book->isbn ?? '';
        $request->author_ids = array_map(fn($author) => $author->id, $book->authors);

        return $request;
    }

    /**
     * Получение привязанной книги
     */
    public function getBook(): ?Book
    {
        return $this->book;
    }
}
