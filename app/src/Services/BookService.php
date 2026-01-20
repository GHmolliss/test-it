<?php

declare(strict_types=1);

class BookService
{
    public function create(array $data, array $authorIds, ?CUploadedFile $coverFile = null): Book
    {
        $transaction = Yii::app()->db->beginTransaction();

        try {
            $book = new Book();
            $book->attributes = $data;

            if ($coverFile) {
                $book->cover_image = $this->uploadCover($coverFile);
            }

            if (!$book->save()) {
                throw new CException('Ошибка сохранения книги');
            }

            $this->syncAuthors($book, $authorIds);
            $this->notifySubscribers($book, $authorIds);

            $transaction->commit();

            return $book;
        } catch (Exception $e) {
            $transaction->rollback();

            throw $e;
        }
    }

    public function update(Book $book, array $data, array $authorIds, ?CUploadedFile $coverFile = null): Book
    {
        $transaction = Yii::app()->db->beginTransaction();

        try {
            $book->attributes = $data;

            if ($coverFile) {
                $this->deleteCover($book->cover_image);
                $book->cover_image = $this->uploadCover($coverFile);
            }

            if (!$book->save()) {
                throw new CException('Ошибка обновления книги');
            }

            $this->syncAuthors($book, $authorIds);

            $transaction->commit();

            return $book;
        } catch (Exception $e) {
            $transaction->rollback();

            throw $e;
        }
    }

    public function delete(Book $book): void
    {
        $this->deleteCover($book->cover_image);

        $book->delete();
    }

    public function findById(int $id): ?Book
    {
        return Book::model()->with('authors')->findByPk($id);
    }

    public function findAll(array $criteria = []): array
    {
        $c = new CDbCriteria($criteria);
        $c->with = ['authors'];
        $c->order = 'book.created_at DESC';

        return Book::model()->findAll($c);
    }

    public function getDataProvider(array $criteria = []): CActiveDataProvider
    {
        $c = new CDbCriteria($criteria);
        $c->with = ['authors'];
        $c->order = 't.created_at DESC';

        return new CActiveDataProvider(Book::model(), [
            'criteria' => $c,
            'pagination' => ['pageSize' => 10],
        ]);
    }

    private function syncAuthors(Book $book, array $authorIds): void
    {
        BookAuthor::model()->deleteAllByAttributes(['book_id' => $book->id]);

        foreach ($authorIds as $authorId) {
            $bookAuthor = new BookAuthor();
            $bookAuthor->book_id = $book->id;
            $bookAuthor->author_id = (int)$authorId;
            $bookAuthor->save();
        }
    }

    private function notifySubscribers(Book $book, array $authorIds): void
    {
        $subscriptions = Subscription::model()->findAllByAttributes(['author_id' => $authorIds]);

        foreach ($subscriptions as $subscription) {
            $notification = new NotificationQueue();
            $notification->phone = $subscription->phone;
            $notification->message = "Новая книга \"{$book->title}\" автора {$subscription->author->full_name}";
            $notification->save();
        }
    }

    private function uploadCover(CUploadedFile $file): string
    {
        $uploadPath = Yii::getPathOfAlias('webroot') . '/' . Yii::app()->params['uploadPath'];

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $filename = uniqid() . '.' . $file->extensionName;
        $file->saveAs($uploadPath . $filename);

        return $filename;
    }

    private function deleteCover(?string $filename): void
    {
        if (!$filename) {
            return;
        }

        $path = Yii::getPathOfAlias('webroot') . '/' . Yii::app()->params['uploadPath'] . $filename;

        if (file_exists($path)) {
            unlink($path);
        }
    }
}
