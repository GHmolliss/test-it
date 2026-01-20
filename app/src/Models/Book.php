<?php

declare(strict_types=1);

/**
 * @property int $id
 * @property string $title
 * @property int $year
 * @property string|null $description
 * @property string|null $isbn
 * @property string|null $cover_image
 * @property string $created_at
 * @property string $updated_at
 * @property Author[] $authors
 */
class Book extends CActiveRecord
{
    public static function model($className = __CLASS__): static
    {
        return parent::model($className);
    }

    public function tableName(): string
    {
        return 'book';
    }

    public function rules(): array
    {
        return [
            ['title, year', 'required'],
            ['title', 'length', 'max' => 255],
            ['year', 'numerical', 'integerOnly' => true, 'min' => 1000, 'max' => 2100],
            ['isbn', 'length', 'max' => 20],
            ['cover_image', 'length', 'max' => 255],
            ['description', 'safe'],
        ];
    }

    public function relations(): array
    {
        return [
            'authors' => [self::MANY_MANY, 'Author', 'book_author(book_id, author_id)'],
            'bookAuthors' => [self::HAS_MANY, 'BookAuthor', 'book_id'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'year' => 'Год выпуска',
            'description' => 'Описание',
            'isbn' => 'ISBN',
            'cover_image' => 'Обложка',
            'created_at' => 'Создана',
            'updated_at' => 'Обновлена',
        ];
    }

    protected function beforeSave(): bool
    {
        if ($this->isNewRecord) {
            $this->created_at = date('Y-m-d H:i:s');
        }
        $this->updated_at = date('Y-m-d H:i:s');

        return parent::beforeSave();
    }

    public function getCoverUrl(): ?string
    {
        if (!$this->cover_image) {
            return null;
        }

        return '/' . Yii::app()->params['uploadPath'] . $this->cover_image;
    }

    public function getAuthorsString(): string
    {
        $names = array_map(fn(Author $author) => $author->full_name, $this->authors);

        return implode(', ', $names);
    }
}
