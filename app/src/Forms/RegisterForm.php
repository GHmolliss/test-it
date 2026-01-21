<?php

declare(strict_types=1);

class RegisterForm extends CFormModel
{
    public string $name = '';
    public string $phone = '';
    public string $password = '';
    public string $password_confirm = '';

    public function rules(): array
    {
        return [
            ['name, phone, password, password_confirm', 'required'],
            ['name', 'length', 'max' => 255],
            ['phone', 'length', 'max' => 20],
            ['phone', 'PhoneValidator'],
            ['password', 'length', 'min' => 6],
            ['password_confirm', 'compare', 'compareAttribute' => 'password', 'operator' => '==', 'message' => 'Пароли не совпадают'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Имя',
            'phone' => 'Телефон',
            'password' => 'Пароль',
            'password_confirm' => 'Повтор пароля',
        ];
    }
}
