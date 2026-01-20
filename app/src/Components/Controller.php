<?php

declare(strict_types=1);

class Controller extends CController
{
    public $layout = '//layouts/main';
    public $breadcrumbs = [];

    protected function beforeAction($action): bool
    {
        return parent::beforeAction($action);
    }

    protected function isGuest(): bool
    {
        return Yii::app()->user->isGuest;
    }

    protected function isUser(): bool
    {
        return !$this->isGuest() && Yii::app()->authManager->checkAccess('user', (string)Yii::app()->user->id);
    }

    protected function requireUser(): void
    {
        if (!$this->isUser()) {
            throw new CHttpException(403, 'Доступ запрещён');
        }
    }

    protected function requireGuest(): void
    {
        if (!$this->isGuest()) {
            $this->redirect(['site/index']);
        }
    }

    protected function setFlash(string $type, string $message): void
    {
        Yii::app()->user->setFlash($type, $message);
    }
}
