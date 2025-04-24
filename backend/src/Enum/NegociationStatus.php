<?php

namespace App\Enum;

final class NegociationStatus
{
    public const PENDING = 'pending';
    public const ACCEPTED = 'accepted';
    public const REFUSED = 'refused';
    public const COUNTER = 'counter';

    public static function getAll(): array
    {
        return [
            self::PENDING,
            self::ACCEPTED,
            self::REFUSED,
            self::COUNTER,
        ];
    }
}
