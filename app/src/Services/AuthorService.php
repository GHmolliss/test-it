<?php

declare(strict_types=1);

class AuthorService
{
    public function create(array $data): Author
    {
        $author = new Author();
        $author->attributes = $data;

        if (!$author->save()) {
            throw new CException('Ошибка сохранения автора');
        }

        return $author;
    }

    public function update(Author $author, array $data): Author
    {
        $author->attributes = $data;

        if (!$author->save()) {
            throw new CException('Ошибка обновления автора');
        }

        return $author;
    }

    public function delete(Author $author): void
    {
        $author->delete();
    }

    public function findById(int $id): ?Author
    {
        return Author::model()->with('books')->findByPk($id);
    }

    public function findAll(): array
    {
        return Author::model()->findAll(['order' => 'full_name ASC']);
    }

    public function getDataProvider(): CActiveDataProvider
    {
        return new CActiveDataProvider(Author::model(), [
            'criteria' => [
                'order' => 'full_name ASC',
            ],
            'pagination' => ['pageSize' => 10],
        ]);
    }

    public function getListData(): array
    {
        return CHtml::listData($this->findAll(), 'id', 'full_name');
    }

    public function getTopAuthors(int $year, int $limit = 10): array
    {
        $sql = "
            SELECT a.*, COUNT(ba.book_id) as books_count
            FROM author a
            INNER JOIN book_author ba ON a.id = ba.author_id
            INNER JOIN book b ON ba.book_id = b.id
            WHERE b.year = :year
            GROUP BY a.id
            ORDER BY books_count DESC
            LIMIT :limit
        ";

        return Yii::app()->db->createCommand($sql)
            ->bindValue(':year', $year)
            ->bindValue(':limit', $limit)
            ->queryAll();
    }
}
