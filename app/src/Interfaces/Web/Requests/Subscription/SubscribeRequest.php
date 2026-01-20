<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Requests\Subscription;

use App\Interfaces\Web\Requests\AbstractRequest;

/**
 * Request DTO для подписки на автора
 */
class SubscribeRequest extends AbstractRequest
{
    public int $author_id = 0;
    public string $phone = '';

    /**
     * Создание из POST-данных
     */
    public static function fromPost(array $data, int $authorId): self
    {
        $request = new self();

        $request->author_id = $authorId;
        $request->phone = trim((string)($data['phone'] ?? ''));

        return $request;
    }

    public function rules(): array
    {
        return [];
    }

    public function attributeLabels(): array
    {
        return [
            'phone' => 'Телефон',
            'author_id' => 'Автор',
        ];
    }

    public function validate(): bool
    {
        $this->errors = [];

        if (empty($this->phone)) {
            $this->addError('phone', 'Телефон не может быть пустым');
        } elseif (!preg_match('/^\+7\d{10}$/', $this->phone)) {
            $this->addError('phone', 'Телефон должен быть в формате +7XXXXXXXXXX');
        }

        if ($this->author_id <= 0) {
            $this->addError('author_id', 'Автор не указан');
        }

        return empty($this->errors);
    }

    public function toArray(): array
    {
        return [
            'author_id' => $this->author_id,
            'phone' => $this->phone,
        ];
    }
}
