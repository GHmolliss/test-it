<?php

declare(strict_types=1);

class SubscriptionService
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function subscribe(int $authorId, string $phone): Subscription
    {
        $normalizedPhone = $this->authService->normalizePhone($phone);

        if (!$this->authService->isValidMobilePhone($phone)) {
            throw new CException('Некорректный мобильный номер телефона');
        }

        $existing = Subscription::model()->findByAttributes([
            'author_id' => $authorId,
            'phone' => $normalizedPhone,
        ]);

        if ($existing) {
            throw new CException('Вы уже подписаны на этого автора');
        }

        $subscription = new Subscription();
        $subscription->author_id = $authorId;
        $subscription->phone = $normalizedPhone;

        if (!$subscription->save()) {
            throw new CException('Ошибка оформления подписки');
        }

        return $subscription;
    }

    public function getSubscribersByAuthor(int $authorId): array
    {
        return Subscription::model()->findAllByAttributes(['author_id' => $authorId]);
    }
}
