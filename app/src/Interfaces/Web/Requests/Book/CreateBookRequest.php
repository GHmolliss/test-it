<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Requests\Book;

use App\Interfaces\Web\Requests\AbstractRequest;
use BookForm;
use CUploadedFile;

/**
 * Request DTO для создания книги
 */
class CreateBookRequest extends AbstractRequest
{
    public string $title = '';
    public int|string $year = '';
    public string $description = '';
    public string $isbn = '';
    public array $author_ids = [];
    public ?CUploadedFile $cover_image = null;

    /**
     * Создание из POST-данных
     * 
     * @param array<string, mixed> $data POST-данные формы
     * @param string $formName Имя формы для получения файла
     */
    public static function fromPost(array $data, string $formName = 'BookForm'): static
    {
        $request = new static();

        $request->title = trim((string)($data['title'] ?? ''));
        $request->year = $data['year'] ?? '';
        $request->description = trim((string)($data['description'] ?? ''));
        $request->isbn = trim((string)($data['isbn'] ?? ''));
        $request->author_ids = $data['author_ids'] ?? [];

        // Получение загруженного файла через временную форму
        $tempForm = new BookForm();
        $request->cover_image = CUploadedFile::getInstance($tempForm, 'cover_image');

        return $request;
    }

    public function rules(): array
    {
        return [
            'title' => ['required'],
            'title_length' => ['string', 'max' => 255],
            'year' => ['required'],
            'year_range' => ['integer', 'min' => 1000, 'max' => 2100],
            'isbn' => ['string', 'max' => 20],
            'author_ids' => ['required', 'message' => 'Выберите хотя бы одного автора'],
            'author_ids_array' => ['array', 'min' => 1, 'message' => 'Выберите хотя бы одного автора'],
            'cover_image' => ['file', 'types' => ['jpg', 'jpeg', 'png', 'gif'], 'maxSize' => 5242880],
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
            'cover_image' => 'Обложка',
        ];
    }

    /**
     * Валидация с учётом связанных атрибутов
     */
    public function validate(): bool
    {
        $this->errors = [];

        // Валидация title
        if (empty($this->title)) {
            $this->addError('title', 'Название не может быть пустым');
        } elseif (mb_strlen($this->title) > 255) {
            $this->addError('title', 'Название не должно превышать 255 символов');
        }

        // Валидация year
        if ($this->year === '' || $this->year === null) {
            $this->addError('year', 'Год выпуска не может быть пустым');
        } elseif (!is_numeric($this->year) || (int)$this->year < 1000 || (int)$this->year > 2100) {
            $this->addError('year', 'Год выпуска должен быть от 1000 до 2100');
        }

        // Валидация isbn
        if (!empty($this->isbn) && mb_strlen($this->isbn) > 20) {
            $this->addError('isbn', 'ISBN не должен превышать 20 символов');
        }

        // Валидация author_ids
        if (empty($this->author_ids)) {
            $this->addError('author_ids', 'Выберите хотя бы одного автора');
        }

        // Валидация cover_image
        if ($this->cover_image !== null) {
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = strtolower($this->cover_image->extensionName);

            if (!in_array($extension, $allowedTypes, true)) {
                $this->addError('cover_image', 'Обложка: допустимые форматы - JPG, PNG, GIF');
            }

            if ($this->cover_image->size > 5242880) {
                $this->addError('cover_image', 'Обложка: размер файла не должен превышать 5 МБ');
            }
        }

        return empty($this->errors);
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

    /**
     * Получение ID авторов
     * 
     * @return int[]
     */
    public function getAuthorIds(): array
    {
        return array_map('intval', $this->author_ids);
    }

    /**
     * Получение загруженного файла обложки
     */
    public function getCoverFile(): ?CUploadedFile
    {
        return $this->cover_image;
    }
}
