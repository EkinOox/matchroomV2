<?php

namespace App\Service;

use App\Entity\User;
use DateTimeImmutable;

class RouletteService
{
    /**
     * Vérifie si l'utilisateur peut jouer à la roulette.
     *
     * @param User $user L'utilisateur pour lequel vérifier la possibilité de jouer.
     * @return bool True si l'utilisateur peut jouer, false sinon.
     */
    public function canPlay(User $user): bool
    {
        $lastLaunch = $user->getLastLaunch();
        $now = new DateTimeImmutable();

        // Logique de vérification (24h ou jamais joué)
        return !$lastLaunch || $now->diff($lastLaunch)->days >= 1;
    }
}
