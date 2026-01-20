<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Requests\Author;

use App\Interfaces\Web\Requests\AbstractRequest;

/**
 * Request DTO для создания автора
 */
class CreateAuthorRequest extends AbstractRequest
{
    public string $first_name = '';
    public string $last_name = '';
    public string $middle_name = '';
    public string $biography = '';

    /**
     * Создание из POST-данных
     */
    public static function fromPost(array $data): static
    {
        $request = new static();
        
        // Если передано full_name, парсим его на части
        if (isset($data['full_name']) && !empty($data['full_name'])) {
            $parts = self::parseFullName(trim((string)$data['full_name']));
            $request->first_name = $parts['first_name'];
            $request->last_name = $parts['last_name'];
            $request->middle_name = $parts['middle_name'];
        } else {
            $request->first_name = trim((string)($data['first_name'] ?? ''));
            $request->last_name = trim((string)($data['last_name'] ?? ''));
            $request->middle_name = trim((string)($data['middle_name'] ?? ''));
        }
        
        $request->biography = trim((string)($data['biography'] ?? ''));

        return $request;
    }

    /**
     * Парсинг ФИО на составляющие (Фамилия Имя Отчество)
     */
    private static function parseFullName(string $fullName): array
    {
        $parts = preg_split('/\s+/', $fullName, -1, PREG_SPLIT_NO_EMPTY);
        
        return [
            'last_name' => $parts[0] ?? '',
            'first_name' => $parts[1] ?? '',
            'middle_name' => $parts[2] ?? '',
        ];
    }

    public function rules(): array
    {
        return [];
    }

    public function attributeLabels(): array
    {
        return [
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'middle_name' => 'Отчество',
            'biography' => 'Биография',
        ];
    }

    public function validate(): bool
    {
        $this->errors = [];

        if (empty($this->first_name)) {
            $this->addError('first_name', 'Имя не может быть пустым');
        } elseif (mb_strlen($this->first_name) > 100) {
            $this->addError('first_name', 'Имя не должно превышать 100 символов');
        }

        if (empty($this->last_name)) {
            $this->addError('last_name', 'Фамилия не может быть пустой');
        } elseif (mb_strlen($this->last_name) > 100) {
            $this->addError('last_name', 'Фамилия не должна превышать 100 символов');
        }

        if (mb_strlen($this->middle_name) > 100) {
            $this->addError('middle_name', 'Отчество не должно превышать 100 символов');
        }

        return empty($this->errors);
    }

    public function toArray(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'middle_name' => $this->middle_name,
            'biography' => $this->biography,
        ];
    }
}
