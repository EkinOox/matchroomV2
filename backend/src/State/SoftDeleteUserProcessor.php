<?php

namespace App\State;

use App\Entity\User;
use ApiPlatform\Metadata\Operation;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use ApiPlatform\State\ProcessorInterface;

class SoftDeleteUserProcessor implements ProcessorInterface
{
    public function __construct(private ProcessorInterface $processore) {}

    /**
     * Processor qui permet de supprimer un utilisateur de manière logique uniquement si l'utilisateur est administrateur
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): User
    {
        if (!$data instanceof User) {
            // throw new InvalidArgumentException('This processor only supports the User entity.');
        }

        // Vérifiez que l'utilisateur est autorisé à effectuer cette action
        $currentUser = $context['current_user'] ?? null;
        if ($currentUser) {
            // L'administrateur peut supprimer n'importe quel utilisateur
            if (!$currentUser->hasRole('ROLE_ADMIN') && $data !== $currentUser) {
                throw new AccessDeniedException('Vous ne pouvez supprimer que votre propre compte.');
            }
        }

        // Marquer l'utilisateur comme supprimé (suppression logique)
        $data->setDeletedAt(new \DateTime());

        // Retourner les données mises à jour
        return $this->processore->process($data, $operation, $uriVariables, $context);
    }
}
