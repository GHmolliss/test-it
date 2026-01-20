<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Actions\Auth;

use App\Interfaces\Web\Actions\AbstractAction;
use App\Interfaces\Web\Requests\Auth\RegisterRequest;
use AuthService;
use CException;
use RegisterForm;
use Yii;

/**
 * Action для регистрации
 */
class RegisterAction extends AbstractAction
{
    public function run(): void
    {
        $this->requireGuest();

        $authService = $this->getService(AuthService::class);

        $form = new RegisterForm();

        if ($this->isPost()) {
            $postData = $this->getPostData('RegisterForm');
            $request = RegisterRequest::fromPost($postData);

            $form->attributes = $postData;

            if ($request->validate()) {
                try {
                    $authService->register($request->name, $request->phone, $request->password);
                    $authService->login($request->phone, $request->password);
                    $this->redirect(['site/index']);
                    return;
                } catch (CException $e) {
                    $this->setFlash('error', $e->getMessage());
                }
            } else {
                $this->transferErrors($request, $form);
            }
        }

        $this->render('register', [
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

    private function transferErrors(RegisterRequest $request, RegisterForm $form): void
    {
        foreach ($request->getErrors() as $attribute => $errors) {
            foreach ($errors as $error) {
                $form->addError($attribute, $error);
            }
        }
    }
}
