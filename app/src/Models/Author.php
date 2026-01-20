<?php

declare(strict_types=1);

/**
 * @property int $id
 * @property string $full_name
 * @property string $created_at
 * @property string $updated_at
 * @property Book[] $books
 * @property Subscription[] $subscriptions
 */
class Author extends CActiveRecord
{
    public static function model($className = __CLASS__): static
    {
        return parent::model($className);
    }

    public function tableName(): string
    {
        return 'author';
    }

    public function rules(): array
    {
        return [
            ['full_name', 'required'],
            ['full_name', 'length', 'max' => 255],
        ];
    }

    public function relations(): array
    {
        return [
            'books' => [self::MANY_MANY, 'Book', 'book_author(author_id, book_id)'],
            'subscriptions' => [self::HAS_MANY, 'Subscription', 'author_id'],
            'booksCount' => [self::STAT, 'Book', 'book_author(author_id, book_id)'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'full_name' => 'ФИО',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлён',
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
}
