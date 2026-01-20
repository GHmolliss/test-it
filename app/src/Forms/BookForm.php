<?php

declare(strict_types=1);

class BookForm extends CFormModel
{
    public string $title = '';
    public int|string $year = '';
    public string $description = '';
    public string $isbn = '';
    public array $author_ids = [];

    public function rules(): array
    {
        return [
            ['title, year', 'required'],
            ['title', 'length', 'max' => 255],
            ['year', 'numerical', 'integerOnly' => true, 'min' => 1000, 'max' => 2100],
            ['isbn', 'length', 'max' => 20],
            ['description', 'safe'],
            ['author_ids', 'required', 'message' => 'Выберите хотя бы одного автора'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'title' => 'Название',
            'year' => 'Год выпуска',
            'description' => 'Описание',
            'isbn' => 'ISBN',
            'author_ids' => 'Авторы',
        ];
    }

    public function loadFromModel(Book $book): void
    {
        $this->title = $book->title;
        $this->year = $book->year;
        $this->description = $book->description ?? '';
        $this->isbn = $book->isbn ?? '';
        $this->author_ids = array_map(fn(Author $a) => $a->id, $book->authors);
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'year' => (int)$this->year,
            'description' => $this->description,
            'isbn' => $this->isbn,
        ];
    }
}
