<?php

declare(strict_types=1);

/**
 * @property int $id
 * @property int $author_id
 * @property string $phone
 * @property string $created_at
 * @property Author $author
 */
class Subscription extends CActiveRecord
{
    public static function model($className = __CLASS__): static
    {
        return parent::model($className);
    }

    public function tableName(): string
    {
        return 'subscription';
    }

    public function rules(): array
    {
        return [
            ['author_id, phone', 'required'],
            ['author_id', 'numerical', 'integerOnly' => true],
            ['phone', 'length', 'max' => 20],
            ['author_id', 'exist', 'className' => 'Author', 'attributeName' => 'id'],
        ];
    }

    public function relations(): array
    {
        return [
            'author' => [self::BELONGS_TO, 'Author', 'author_id'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'author_id' => 'Автор',
            'phone' => 'Телефон',
            'created_at' => 'Подписан',
        ];
    }

    protected function beforeSave(): bool
    {
        if ($this->isNewRecord) {
            $this->created_at = date('Y-m-d H:i:s');
        }

        return parent::beforeSave();
    }
}
