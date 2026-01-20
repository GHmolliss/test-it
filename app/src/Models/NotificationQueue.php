<?php

declare(strict_types=1);

/**
 * @property int $id
 * @property string $phone
 * @property string $message
 * @property string $status
 * @property int $attempts
 * @property string $created_at
 * @property string|null $sent_at
 */
class NotificationQueue extends CActiveRecord
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_SENT = 'sent';
    public const STATUS_FAILED = 'failed';

    public static function model($className = __CLASS__): static
    {
        return parent::model($className);
    }

    public function tableName(): string
    {
        return 'notification_queue';
    }

    public function rules(): array
    {
        return [
            ['phone, message', 'required'],
            ['phone', 'length', 'max' => 20],
            ['status', 'in', 'range' => [self::STATUS_PENDING, self::STATUS_SENT, self::STATUS_FAILED]],
            ['attempts', 'numerical', 'integerOnly' => true],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'phone' => 'Телефон',
            'message' => 'Сообщение',
            'status' => 'Статус',
            'attempts' => 'Попытки',
            'created_at' => 'Создано',
            'sent_at' => 'Отправлено',
        ];
    }

    protected function beforeSave(): bool
    {
        if ($this->isNewRecord) {
            $this->created_at = date('Y-m-d H:i:s');
            $this->status = self::STATUS_PENDING;
            $this->attempts = 0;
        }

        return parent::beforeSave();
    }

    public function markAsSent(): void
    {
        $this->status = self::STATUS_SENT;
        $this->sent_at = date('Y-m-d H:i:s');
        $this->save(false);
    }

    public function markAsFailed(): void
    {
        $this->attempts++;
        if ($this->attempts >= 3) {
            $this->status = self::STATUS_FAILED;
        }
        $this->save(false);
    }
}
