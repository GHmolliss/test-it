<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Actions;

use CActiveRecord;
use CHttpException;

/**
 * Трейт для Action, работающих с сущностями
 * 
 * Предоставляет метод загрузки сущности по ID с выбросом 404
 */
trait EntityLoaderTrait
{
    /**
     * Загрузка сущности по ID с выбросом 404
     * 
     * @template T of \CActiveRecord
     * @param class-string<T> $modelClass
     * @param int $id
     * @param string $notFoundMessage
     * @param array<string> $with Связи для eager loading
     * @return T
     * @throws CHttpException если сущность не найдена
     */
    protected function loadEntity(
        string $modelClass,
        int $id,
        string $notFoundMessage = 'Запись не найдена',
        array $with = []
    ): CActiveRecord {
        /** @var CActiveRecord $model */
        $model = $modelClass::model();

        if (!empty($with)) {
            $model = $model->with($with);
        }

        $entity = $model->findByPk($id);

        if ($entity === null) {
            throw new CHttpException(404, $notFoundMessage);
        }

        return $entity;
    }
}
