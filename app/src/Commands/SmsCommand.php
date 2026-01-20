<?php

declare(strict_types=1);

class SmsCommand extends CConsoleCommand
{
    public function actionSend(): void
    {
        $smsService = new SmsService();
        $results = $smsService->processPendingNotifications();

        echo "Отправлено: {$results['sent']}, Ошибки: {$results['failed']}\n";
    }

    public function getHelp(): string
    {
        return <<<HELP
        USAGE
          yiic sms send

        DESCRIPTION
          Отправляет SMS-уведомления из очереди подписчикам о новых книгах.
          Рекомендуется запускать по cron каждую минуту.

        CRONTAB
          * * * * * cd /var/www/html && php yiic sms send
        HELP;
    }
}
