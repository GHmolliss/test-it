<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Requests\Author;

use Author;

/**
 * Request DTO для обновления автора
 */
class UpdateAuthorRequest extends CreateAuthorRequest
{
    private ?Author $author = null;

    /**
     * Создание из POST-данных с привязкой к существующему автору
     */
    public static function fromPostWithAuthor(array $data, Author $author): self
    {
        /** @var self $request */
        $request = self::fromPost($data);
        $request->author = $author;

        return $request;
    }

    /**
     * Заполнение данными из существующего автора
     */
    public static function fromAuthor(Author $author): self
    {
        $request = new self();

        $request->author = $author;
        $request->first_name = $author->first_name;
        $request->last_name = $author->last_name;
        $request->middle_name = $author->middle_name ?? '';
        $request->biography = $author->biography ?? '';

        return $request;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }
}
