<?php

declare(strict_types=1);

/**
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $password_hash
 * @property string $created_at
 * @property string $updated_at
 */
class User extends CActiveRecord
{
    public static function model($className = __CLASS__): static
    {
        return parent::model($className);
    }

    public function tableName(): string
    {
        return 'user';
    }

    public function rules(): array
    {
        return [
            ['name, phone, password_hash', 'required'],
            ['name', 'length', 'max' => 255],
            ['phone', 'length', 'max' => 20],
            ['phone', 'unique'],
            ['password_hash', 'length', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлён',
        ];
    }

    protected function beforeSave(): bool
    {
        if ($this->isNewRecord) {
            $this->created_at = date('Y-m-d H:i:s');
        }
        $this->updated_at = date('Y-m-d H:i:s');

        return parent::beforeSave();
    }

    public function validatePassword(string $password): bool
    {
        return password_verify($password, $this->password_hash);
    }

    public function setPassword(string $password): void
    {
        $this->password_hash = password_hash($password, PASSWORD_DEFAULT);
    }
}
