<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Actions\Auth;

use App\Interfaces\Web\Actions\AbstractAction;
use AuthService;

class LogoutAction extends AbstractAction
{
    public function run(): void
    {
        $authService = $this->getService(AuthService::class);
        $authService->logout();

        $this->redirect(['site/index']);
    }
}
