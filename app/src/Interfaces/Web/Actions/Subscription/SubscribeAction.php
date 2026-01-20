<?php

declare(strict_types=1);

namespace App\Interfaces\Web\Actions\Subscription;

use App\Interfaces\Web\Actions\AbstractAction;
use App\Interfaces\Web\Actions\EntityLoaderTrait;
use App\Interfaces\Web\Requests\Subscription\SubscribeRequest;
use Author;
use CController;
use CException;
use SubscriptionForm;
use SubscriptionService;

/**
 * Action для подписки на автора
 */
class SubscribeAction extends AbstractAction
{
    use EntityLoaderTrait;

    private int $authorId;

    public function __construct(CController $controller, int $authorId)
    {
        parent::__construct($controller);
        $this->authorId = $authorId;
    }

    public function run(): void
    {
        $subscriptionService = $this->getService(SubscriptionService::class);

        /** @var Author $author */
        $author = $this->loadEntity(
            Author::class,
            $this->authorId,
            'Автор не найден'
        );

        $form = new SubscriptionForm();
        $form->author_id = $this->authorId;

        if ($this->isPost()) {
            $postData = $this->getPostData('SubscriptionForm');
            $request = SubscribeRequest::fromPost($postData, $this->authorId);

            $form->attributes = $postData;
            $form->author_id = $this->authorId;

            if ($request->validate()) {
                try {
                    $subscriptionService->subscribe($this->authorId, $request->phone);
                    
                    $this->setFlash('success', 'Вы успешно подписались на новые книги автора ' . $author->full_name);
                    $this->redirect(['author/view', 'id' => $this->authorId]);
                    return;
                } catch (CException $e) {
                    $this->setFlash('error', $e->getMessage());
                }
            } else {
                $this->transferErrors($request, $form);
            }
        }

        $this->render('subscribe', [
            'model' => $form,
            'author' => $author,
        ]);
    }

    private function transferErrors(SubscribeRequest $request, SubscriptionForm $form): void
    {
        foreach ($request->getErrors() as $attribute => $errors) {
            foreach ($errors as $error) {
                $form->addError($attribute, $error);
            }
        }
    }
}
