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
            if (in_array('ROLE_HOTELIER', $user->getRoles())) {
                $payload['hotel'] = $user->getHotel()->getId();
            }
        }

        $event->setData($payload);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'lexik_jwt_authentication.on_jwt_created' => 'onLexikJwtAuthenticationOnJwtCreated',
        ];
    }
}
