<?php

namespace App\Security\Exception;

class TooManyRequestsException  extends \Exception
{
    private int $retryAfterMinutes;
    private string $customMessage;

    public function __construct(int $retryAfterTimestamp, string $customMessage = 'Trop de tentatives. Veuillez réessayer dans :')
    {
        // Convertir le timestamp en minutes restantes
        $this->retryAfterMinutes = ceil(($retryAfterTimestamp - time()) / 60);
        $this->customMessage = $customMessage;

        parent::__construct($customMessage);
    }

    public function getMessageKey(): string
    {
        return "{$this->customMessage} {$this->retryAfterMinutes} minutes.";
    }

    public function getRetryAfterMinutes(): int
    {
        return $this->retryAfterMinutes;
    }
}
