<?php

declare(strict_types=1);

class UserIdentity extends CUserIdentity
{
    private ?User $user = null;
    private int $id = 0;

    public function setUser(User $user): void
    {
        $this->user = $user;
        $this->id = (int)$user->id;
    }

    public function authenticate(): bool
    {
        if ($this->user) {
            $this->errorCode = self::ERROR_NONE;
            return true;
        }

        $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
        return false;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->user?->name ?? '';
    }
}
