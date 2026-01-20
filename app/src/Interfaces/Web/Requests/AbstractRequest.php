<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Requests;

use CUploadedFile;

/**
 * Базовый класс для Request DTO
 * 
 * Отвечает за:
 * - Приём и хранение входных данных
 * - Валидация данных
 * - Преобразование в массив для сервиса
 */
abstract class AbstractRequest
{
    /** @var array<string, string[]> Ошибки валидации */
    protected array $errors = [];

    /**
     * Правила валидации
     * 
     * @return array<string, array{0: string, 1?: mixed, ...}> Правила в формате:
     *   ['attribute' => ['rule', 'param1' => value1, ...]]
     */
    abstract public function rules(): array;

    /**
     * Метки атрибутов
     * 
     * @return array<string, string>
     */
    public function attributeLabels(): array
    {
        return [];
    }

    /**
     * Валидация данных
     */
    public function validate(): bool
    {
        $this->errors = [];

        foreach ($this->rules() as $attribute => $rule) {
            $this->validateAttribute($attribute, $rule);
        }

        return empty($this->errors);
    }

    /**
     * Получение ошибок
     * 
     * @return array<string, string[]>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Проверка наличия ошибок
     */
    public function hasErrors(?string $attribute = null): bool
    {
        if ($attribute === null) {
            return !empty($this->errors);
        }

        return isset($this->errors[$attribute]) && !empty($this->errors[$attribute]);
    }

    /**
     * Получение первой ошибки атрибута
     */
    public function getFirstError(string $attribute): ?string
    {
        return $this->errors[$attribute][0] ?? null;
    }

    /**
     * Добавление ошибки
     */
    public function addError(string $attribute, string $message): void
    {
        $this->errors[$attribute][] = $message;
    }

    /**
     * Преобразование в массив для сервиса
     * 
     * @return array<string, mixed>
     */
    abstract public function toArray(): array;

    /**
     * Получение метки атрибута
     */
    protected function getLabel(string $attribute): string
    {
        return $this->attributeLabels()[$attribute] ?? ucfirst($attribute);
    }

    /**
     * Валидация одного атрибута
     * 
     * @param array<string, mixed> $rule
     */
    protected function validateAttribute(string $attribute, array $rule): void
    {
        $value = $this->$attribute ?? null;
        $ruleName = $rule[0] ?? '';

        switch ($ruleName) {
            case 'required':
                $this->validateRequired($attribute, $value, $rule);
                break;
            case 'string':
                $this->validateString($attribute, $value, $rule);
                break;
            case 'integer':
                $this->validateInteger($attribute, $value, $rule);
                break;
            case 'array':
                $this->validateArray($attribute, $value, $rule);
                break;
            case 'file':
                $this->validateFile($attribute, $value, $rule);
                break;
        }
    }

    /**
     * @param array<string, mixed> $rule
     */
    protected function validateRequired(string $attribute, mixed $value, array $rule): void
    {
        $isEmpty = $value === null || $value === '' || $value === [];

        if ($isEmpty) {
            $message = $rule['message'] ?? "{$this->getLabel($attribute)} не может быть пустым";
            $this->addError($attribute, $message);
        }
    }

    /**
     * @param array<string, mixed> $rule
     */
    protected function validateString(string $attribute, mixed $value, array $rule): void
    {
        if ($value === null || $value === '') {
            return;
        }

        if (!is_string($value)) {
            $this->addError($attribute, "{$this->getLabel($attribute)} должен быть строкой");
            return;
        }

        if (isset($rule['max']) && mb_strlen($value) > $rule['max']) {
            $this->addError($attribute, "{$this->getLabel($attribute)} не должен превышать {$rule['max']} символов");
        }

        if (isset($rule['min']) && mb_strlen($value) < $rule['min']) {
            $this->addError($attribute, "{$this->getLabel($attribute)} должен быть не менее {$rule['min']} символов");
        }
    }

    /**
     * @param array<string, mixed> $rule
     */
    protected function validateInteger(string $attribute, mixed $value, array $rule): void
    {
        if ($value === null || $value === '') {
            return;
        }

        if (!is_numeric($value) || (int)$value != $value) {
            $this->addError($attribute, "{$this->getLabel($attribute)} должен быть целым числом");
            return;
        }

        $intValue = (int)$value;

        if (isset($rule['min']) && $intValue < $rule['min']) {
            $this->addError($attribute, "{$this->getLabel($attribute)} должен быть не менее {$rule['min']}");
        }

        if (isset($rule['max']) && $intValue > $rule['max']) {
            $this->addError($attribute, "{$this->getLabel($attribute)} должен быть не более {$rule['max']}");
        }
    }

    /**
     * @param array<string, mixed> $rule
     */
    protected function validateArray(string $attribute, mixed $value, array $rule): void
    {
        if ($value === null || $value === []) {
            return;
        }

        if (!is_array($value)) {
            $this->addError($attribute, "{$this->getLabel($attribute)} должен быть массивом");
            return;
        }

        if (isset($rule['min']) && count($value) < $rule['min']) {
            $message = $rule['message'] ?? "{$this->getLabel($attribute)} должен содержать не менее {$rule['min']} элементов";
            $this->addError($attribute, $message);
        }
    }

    /**
     * @param array<string, mixed> $rule
     */
    protected function validateFile(string $attribute, mixed $value, array $rule): void
    {
        if ($value === null) {
            return;
        }

        if (!($value instanceof CUploadedFile)) {
            return;
        }

        if (isset($rule['types'])) {
            $allowedTypes = is_array($rule['types']) ? $rule['types'] : explode(',', $rule['types']);
            $extension = strtolower($value->extensionName);

            if (!in_array($extension, $allowedTypes, true)) {
                $this->addError($attribute, "{$this->getLabel($attribute)}: недопустимый тип файла");
            }
        }

        if (isset($rule['maxSize']) && $value->size > $rule['maxSize']) {
            $maxSizeMb = round($rule['maxSize'] / 1048576, 2);
            $this->addError($attribute, "{$this->getLabel($attribute)}: размер файла не должен превышать {$maxSizeMb} МБ");
        }
    }
}
