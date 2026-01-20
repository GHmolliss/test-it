<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Requests\Auth;

use App\Interfaces\Web\Requests\AbstractRequest;

/**
 * Request DTO для входа
 */
class LoginRequest extends AbstractRequest
{
    public string $phone = '';
    public string $password = '';

    /**
     * Создание из POST-данных
     */
    public static function fromPost(array $data): self
    {
        $request = new self();

        $request->phone = trim((string)($data['phone'] ?? ''));
        $request->password = (string)($data['password'] ?? '');

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
            'password' => 'Пароль',
        ];
    }

    public function validate(): bool
    {
        $this->errors = [];

        if (empty($this->phone)) {
            $this->addError('phone', 'Телефон не может быть пустым');
        }

        if (empty($this->password)) {
            $this->addError('password', 'Пароль не может быть пустым');
        }

        return empty($this->errors);
    }

    public function toArray(): array
    {
        return [
            'phone' => $this->phone,
            'password' => $this->password,
        ];
    }
}
