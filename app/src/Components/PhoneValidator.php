<?php

declare(strict_types=1);

class PhoneValidator extends CValidator
{
    protected function validateAttribute($object, $attribute): void
    {
        $authService = new AuthService();
        $value = $object->$attribute;

        if (!$authService->isValidMobilePhone($value)) {
            $this->addError($object, $attribute, 'Укажите корректный мобильный номер (код оператора 900-999)');
        }
    }
}
