<?php

declare(strict_types=1);

class SubscriptionForm extends CFormModel
{
    public string $phone = '';
    public int $author_id = 0;

    public function rules(): array
    {
        return [
            ['phone, author_id', 'required'],
            ['phone', 'length', 'max' => 20],
            ['phone', 'PhoneValidator'],
            ['author_id', 'numerical', 'integerOnly' => true],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'phone' => 'Телефон для уведомлений',
            'author_id' => 'Автор',
        ];
    }
}
