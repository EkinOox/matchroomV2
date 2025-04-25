<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class JWTSubscriber implements EventSubscriberInterface
{
    public function onLexikJwtAuthenticationOnJwtCreated(JWTCreatedEvent $event): void
    {
        $payload = $event->getData();
        $user = $event->getUser();

        // On ajoute dans le token les données que l'on souhaite
        if ($user instanceof User) {
            $payload['id'] = $user->getId();
            $payload['email'] = $user->getEmail();
            $payload['firstname'] = $user->getFirstname();
            $payload['lastname'] = $user->getLastname();
            $payload['roles'] = $user->getRoles();

            // Ajouter les badges (s'il y en a) dans le token
            $badges = [];
            foreach ($user->getBadges() as $badge) {
                $badges[] = [
                    'id' => $badge->getId(),
                    'name' => $badge->getName(),
                    'description' => $badge->getDescription(),
                    'level' => $badge->getLevel(),
                ];
            }
            $payload['badges'] = $badges;

            // Si l'utilisateur a un hôtel associé, on ajoute les informations de l'hôtel
            if ($user->getHotel()) {
                $payload['hotel'] = [
                    'id' => $user->getHotel()->getId(),
                    'name' => $user->getHotel()->getName(),
                ];
            }
        }

        // On remplace les données du token
        $event->setData($payload);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'lexik_jwt_authentication.on_jwt_created' => 'onLexikJwtAuthenticationOnJwtCreated',
        ];
    }
}
