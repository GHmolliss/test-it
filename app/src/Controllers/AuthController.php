<?php

declare(strict_types=1);

use App\Interfaces\Web\Actions\Auth\LoginAction;
use App\Interfaces\Web\Actions\Auth\LogoutAction;
use App\Interfaces\Web\Actions\Auth\RegisterAction;

class AuthController extends Controller
{
    public function actionLogin(): void
    {
        $action = new LoginAction($this);
        $action->run();
    }

    public function actionRegister(): void
    {
        $action = new RegisterAction($this);
        $action->run();
    }

    public function actionLogout(): void
    {
        $action = new LogoutAction($this);
        $action->run();
    }
}
