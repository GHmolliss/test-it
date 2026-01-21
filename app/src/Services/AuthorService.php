<?php

declare(strict_types=1);

class AuthorService
{
    public function create(array $data): Author
    {
        $author = new Author();

        // Если переданы части имени, собираем full_name
        if (isset($data['first_name']) || isset($data['last_name']) || isset($data['middle_name'])) {
            $fullNameParts = [];
            if (!empty($data['last_name'])) {
                $fullNameParts[] = $data['last_name'];
            }
            if (!empty($data['first_name'])) {
                $fullNameParts[] = $data['first_name'];
            }
            if (!empty($data['middle_name'])) {
                $fullNameParts[] = $data['middle_name'];
            }
            $author->full_name = implode(' ', $fullNameParts);
        } else {
            $author->attributes = $data;
        }

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
        $sql = <<<SQL
            SELECT
                a.*, COUNT(ba.`book_id`) as books_count
            FROM `author` a
            INNER JOIN `book_author` ba ON a.`id` = ba.`author_id`
            INNER JOIN `book` b ON ba.`book_id` = b.`id`
            WHERE b.`year` = :year
            GROUP BY a.`id`
            ORDER BY `books_count` DESC
            LIMIT :limit
        SQL;

        return Yii::app()->db->createCommand($sql)
            ->bindValue(':year', $year)
            ->bindValue(':limit', $limit)
            ->queryAll();
    }
}
