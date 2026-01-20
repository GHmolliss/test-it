<?php

declare(strict_types=1);

class AuthService
{
    public function register(string $name, string $phone, string $password): User
    {
        $user = new User();
        $user->name = $name;
        $user->phone = $this->normalizePhone($phone);
        $user->setPassword($password);

        if (!$user->save()) {
            throw new CException('Ошибка регистрации: ' . implode(', ', $user->getErrors()[array_key_first($user->getErrors())]));
        }

        $auth = Yii::app()->authManager;
        $auth->assign('user', (string)$user->id);

        return $user;
    }

    public function login(string $phone, string $password): bool
    {
        $phone = $this->normalizePhone($phone);
        $user = User::model()->findByAttributes(['phone' => $phone]);

        if (!$user || !$user->validatePassword($password)) {
            return false;
        }

        $identity = new UserIdentity($phone, $password);
        $identity->setUser($user);

        return Yii::app()->user->login($identity, 3600 * 24 * 30);
    }

    public function logout(): void
    {
        Yii::app()->user->logout();
    }

    public function normalizePhone(string $phone): string
    {
        return preg_replace('/\D/', '', $phone);
    }

    public function isValidMobilePhone(string $phone): bool
    {
        $normalized = $this->normalizePhone($phone);

        if (strlen($normalized) === 11 && str_starts_with($normalized, '8')) {
            $normalized = '7' . substr($normalized, 1);
        }

        if (strlen($normalized) === 10) {
            $normalized = '7' . $normalized;
        }

        if (strlen($normalized) !== 11 || !str_starts_with($normalized, '7')) {
            return false;
        }

        $operatorCode = (int)substr($normalized, 1, 3);

        return $operatorCode >= 900 && $operatorCode <= 999;
    }
}
