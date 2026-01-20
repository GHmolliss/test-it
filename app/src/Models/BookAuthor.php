<?php

declare(strict_types=1);

/**
 * @property int $book_id
 * @property int $author_id
 * @property Book $book
 * @property Author $author
 */
class BookAuthor extends CActiveRecord
{
    public static function model($className = __CLASS__): static
    {
        return parent::model($className);
    }

    public function tableName(): string
    {
        return 'book_author';
    }

    public function primaryKey(): array
    {
        return ['book_id', 'author_id'];
    }

    public function rules(): array
    {
        return [
            ['book_id, author_id', 'required'],
            ['book_id, author_id', 'numerical', 'integerOnly' => true],
        ];
    }

    public function relations(): array
    {
        return [
            'book' => [self::BELONGS_TO, 'Book', 'book_id'],
            'author' => [self::BELONGS_TO, 'Author', 'author_id'],
        ];
    }
}
