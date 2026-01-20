<?php

declare(strict_types=1);

class LoginForm extends CFormModel
{
    public string $phone = '';
    public string $password = '';
    public bool $rememberMe = false;

    public function rules(): array
    {
        return [
            ['phone, password', 'required'],
            ['phone', 'length', 'max' => 20],
            ['rememberMe', 'boolean'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'phone' => 'Телефон',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить меня',
        ];
    }
}
