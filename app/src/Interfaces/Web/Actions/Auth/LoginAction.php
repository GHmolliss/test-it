<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Actions\Auth;

use App\Interfaces\Web\Actions\AbstractAction;
use App\Interfaces\Web\Requests\Auth\LoginRequest;
use AuthService;
use LoginForm;
use Yii;

class LoginAction extends AbstractAction
{
    public function run(): void
    {
        $this->requireGuest();

        $authService = $this->getService(AuthService::class);

        $form = new LoginForm();

        if ($this->isPost()) {
            $postData = $this->getPostData('LoginForm');
            $request = LoginRequest::fromPost($postData);

            $form->attributes = $postData;

            if ($request->validate()) {
                if ($authService->login($request->phone, $request->password)) {
                    $this->redirect(['site/index']);
                    return;
                }
                $this->setFlash('error', 'Неверный телефон или пароль');
            } else {
                $this->transferErrors($request, $form);
            }
        }

        $this->render('login', [
            'model' => $form,
        ]);
    }

    /**
     * Проверка что пользователь гость
     */
    protected function requireGuest(): void
    {
        if (!Yii::app()->user->isGuest) {
            $this->redirect(['site/index']);
        }
    }

    private function transferErrors(LoginRequest $request, LoginForm $form): void
    {
        foreach ($request->getErrors() as $attribute => $errors) {
            foreach ($errors as $error) {
                $form->addError($attribute, $error);
            }
        }
    }
}
