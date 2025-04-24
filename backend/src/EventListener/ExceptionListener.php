<?php

namespace App\EventListener;

use App\Security\Exception\TooManyRequestsException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\Response;

class ExceptionListener
{
    /*
    * Cette méthode est appelée à chaque fois qu'une exception est lancée dans l'application.
    * 
    * @param ExceptionEvent $event
    */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof TooManyRequestsException) {
            $response = new JsonResponse([
                'message' => $exception->getMessageKey()
            ], Response::HTTP_TOO_MANY_REQUESTS);

            $event->setResponse($response);
        }
    }
}
