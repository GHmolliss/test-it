<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Actions;

use App\Components\Container;
use CController;
use CHttpException;
use CHttpRequest;
use Yii;

/**
 * Базовый класс для всех Action
 * 
 * Отвечает за:
 * - Доступ к контроллеру (для render, redirect, flash)
 * - Получение сервисов из контейнера
 * - Загрузку сущностей с выбросом 404
 */
abstract class AbstractAction
{
    protected CController $controller;
    protected Container $container;

    public function __construct(CController $controller)
    {
        $this->controller = $controller;
        $this->container = Container::getInstance();
    }

    /**
     * Основной метод выполнения действия
     * 
     * @return mixed
     */
    abstract public function run();

    /**
     * Получение сервиса из контейнера
     * 
     * @template T
     * @param class-string<T> $serviceClass
     * @return T
     */
    protected function getService(string $serviceClass): object
    {
        return $this->container->get($serviceClass);
    }

    /**
     * Рендеринг представления
     * 
     * @param string $view Имя представления
     * @param array<string, mixed> $data Данные для представления
     */
    protected function render(string $view, array $data = []): void
    {
        $this->controller->render($view, $data);
    }

    /**
     * Редирект
     * 
     * @param array<int|string, mixed>|string $url URL или route
     */
    protected function redirect(array|string $url): void
    {
        $this->controller->redirect($url);
    }

    /**
     * Установка flash-сообщения
     */
    protected function setFlash(string $key, string $message): void
    {
        Yii::app()->user->setFlash($key, $message);
    }

    /**
     * Проверка авторизации пользователя
     * 
     * @throws CHttpException если пользователь не авторизован
     */
    protected function requireUser(): void
    {
        if (Yii::app()->user->isGuest) {
            throw new CHttpException(401, 'Требуется авторизация');
        }
    }

    /**
     * Текущий HTTP-запрос
     */
    protected function getRequest(): CHttpRequest
    {
        return Yii::app()->request;
    }

    /**
     * Проверка POST-запроса
     */
    protected function isPost(): bool
    {
        return $this->getRequest()->isPostRequest;
    }

    /**
     * Получение POST-данных
     * 
     * @return array<string, mixed>
     */
    protected function getPostData(string $key): array
    {
        return $_POST[$key] ?? [];
    }
}
