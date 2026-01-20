<?php

declare(strict_types=1);

use App\Interfaces\Web\Actions\Subscription\SubscribeAction;

class SubscriptionController extends Controller
{
    public function actionSubscribe(int $id): void
    {
        $action = new SubscribeAction($this, $id);
        $action->run();
    }
}
