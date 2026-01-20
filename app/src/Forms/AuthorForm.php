<?php

declare(strict_types=1);

class AuthorForm extends CFormModel
{
    public string $full_name = '';

    public function rules(): array
    {
        return [
            ['full_name', 'required'],
            ['full_name', 'length', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'full_name' => 'ФИО',
        ];
    }

    public function loadFromModel(Author $author): void
    {
        $this->full_name = $author->full_name;
    }

    public function toArray(): array
    {
        return [
            'full_name' => $this->full_name,
        ];
    }
}
