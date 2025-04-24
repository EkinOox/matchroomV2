<?php

namespace App\State\User;

use App\Entity\User;
use App\Entity\ReferralLink;
use App\Dto\User\UserCreateDTO;
use App\Dto\User\Admin\AdminCreateDTO;
use App\Repository\UserRepository;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\ReferralLinkRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @implements ProcessorInterface<UserCreateDTO|AdminCreateDTO, User>
 */
final class UserCreateProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: PersistProcessor::class)]
        private ProcessorInterface $persistProcessor,
        private UserPasswordHasherInterface $passwordHasher,
        private UserRepository $userRepository,
        // private ReferralLinkRepository $referralLinkRepository
    ) {}

    /**
     * Traite la création d'une nouvelle entité utilisateur.
     *
     * Cette méthode gère la logique de création d'un nouvel utilisateur, y compris le hachage du mot de passe,
     * la génération d'un code de parrainage unique, l'attribution de bonus de parrainage, et la validation
     * des contraintes de l'entité utilisateur.
     *
     * @param mixed $data Les données de l'objet de transfert de données (DTO) contenant les informations de création.
     * @param Operation $operation L'opération API en cours d'exécution.
     * @param array $uriVariables Les variables URI pour l'opération.
     * @param array $context Le contexte de l'opération.
     * @return JsonResponse Une réponse JSON indiquant le succès de la création ou les erreurs de validation.
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): JsonResponse
    {
        /** @var UserCreateDTO|AdminCreateDTO $data */
        $user = new User();
        $user->setEmail($data->email);
        $user->setPseudo($data->pseudo);

        // Hacher le mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword($user, $data->password);
        $user->setPassword($hashedPassword);

        // Rôles par défaut
        if ($data instanceof AdminCreateDTO) {
            $user->setRoles($data->roles);

            // Si l'admin a spécifié un solde, l'appliquer
            if ($data->balance !== null) {
                $user->setBalance($data->balance);
            }
        } else {
            $user->setRoles(['ROLE_USER']);
        }

        // Génération d’un code de parrainage unique
        do {
            $referralCode = bin2hex(random_bytes(6));
        } while ($this->userRepository->findOneBy(['referralCode' => $referralCode]) !== null);

        $user->setReferralCode($referralCode);

        // Si un code de parrainage est fourni, appliquer le bonus
        if ($data->referralCode) {
            $referrer = $this->userRepository->findOneBy(['referralCode' => $data->referralCode]);

            // Si aucun parrain n'est trouvé, lever une exception
            if (!$referrer) {
                throw new BadRequestHttpException('Code parrain invalide.');
            }

            // Ajouter des bonus au parrain et au filleul
            $user->setBalance($user->getBalance() + 50);
            $referrer->setBalance($referrer->getBalance() + 100);

            // Créer un lien de parrainage
            $link = new ReferralLink();
            $link->setReferrer($referrer);
            $link->setReferred($user);
            $this->referralLinkRepository->save($link);
        }

        // Sauvegarde via le persistProcessor
        $this->persistProcessor->process($user, $operation, $uriVariables, $context);

        return new JsonResponse(['message' => 'Utilisateur créé avec succès'], JsonResponse::HTTP_CREATED);
    }
}
