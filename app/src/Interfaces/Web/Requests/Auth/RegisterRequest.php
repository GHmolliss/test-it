<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Requests\Auth;

use App\Interfaces\Web\Requests\AbstractRequest;

/**
 * Request DTO для регистрации
 */
class RegisterRequest extends AbstractRequest
{
    public string $name = '';
    public string $phone = '';
    public string $password = '';
    public string $password_repeat = '';

    /**
     * Создание из POST-данных
     */
    public static function fromPost(array $data): self
    {
        $request = new self();
        
        $request->name = trim((string)($data['name'] ?? ''));
        $request->phone = trim((string)($data['phone'] ?? ''));
        $request->password = (string)($data['password'] ?? '');
        $request->password_repeat = (string)($data['password_repeat'] ?? '');

        return $request;
    }

    public function rules(): array
    {
        return [];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Имя',
            'phone' => 'Телефон',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
        ];
    }

    public function validate(): bool
    {
        $this->errors = [];

        if (empty($this->name)) {
            $this->addError('name', 'Имя не может быть пустым');
        } elseif (mb_strlen($this->name) > 255) {
            $this->addError('name', 'Имя не должно превышать 255 символов');
        }

        if (empty($this->phone)) {
            $this->addError('phone', 'Телефон не может быть пустым');
        } elseif (!preg_match('/^\+7\d{10}$/', $this->phone)) {
            $this->addError('phone', 'Телефон должен быть в формате +7XXXXXXXXXX');
        }

        if (empty($this->password)) {
            $this->addError('password', 'Пароль не может быть пустым');
        } elseif (mb_strlen($this->password) < 6) {
            $this->addError('password', 'Пароль должен быть не менее 6 символов');
        }

        if ($this->password !== $this->password_repeat) {
            $this->addError('password_repeat', 'Пароли не совпадают');
        }

        return empty($this->errors);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'phone' => $this->phone,
            'password' => $this->password,
        ];
    }
}
