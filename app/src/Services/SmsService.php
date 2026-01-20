<?php

declare(strict_types=1);

class SmsService
{
    private const API_URL = 'https://smspilot.ru/api.php';

    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = Yii::app()->params['smsPilotApiKey'];
    }

    public function send(string $phone, string $message): bool
    {
        $params = [
            'send' => $message,
            'to' => $phone,
            'apikey' => $this->apiKey,
            'format' => 'json',
        ];

        $url = self::API_URL . '?' . http_build_query($params);

        $response = @file_get_contents($url);

        if ($response === false) {
            return false;
        }

        $data = json_decode($response, true);

        return isset($data['send']) && !isset($data['error']);
    }

    public function processPendingNotifications(int $limit = 50): array
    {
        $notifications = NotificationQueue::model()->findAll([
            'condition' => "status = :status AND attempts < 3",
            'params' => [':status' => NotificationQueue::STATUS_PENDING],
            'limit' => $limit,
        ]);

        $results = ['sent' => 0, 'failed' => 0];

        foreach ($notifications as $notification) {
            if ($this->send($notification->phone, $notification->message)) {
                $notification->markAsSent();
                $results['sent']++;
            } else {
                $notification->markAsFailed();
                $results['failed']++;
            }
        }

        return $results;
    }
}
