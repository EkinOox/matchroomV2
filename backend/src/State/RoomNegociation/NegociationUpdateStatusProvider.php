<?php

namespace App\State\RoomNegociation;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\Negociation\NegociationUpdateStatusDTO;
use App\Entity\Negociation;
use App\Repository\NegociationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NegociationUpdateStatusProvider implements ProcessorInterface
{
    public function __construct(
        private NegociationRepository $repository,
        private EntityManagerInterface $em
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Negociation
    {
        /** @var Negociation $negociation */
        $negociation = $this->repository->find($uriVariables['id'] ?? null);

        if (!$negociation) {
            throw new NotFoundHttpException('Négociation non trouvée.');
        }

        /** @var NegociationUpdateStatusDTO $data */
        if ($data->counterOffer) {
            $negociation->setCounterOffer($data->counterOffer);
        }

        if ($data->status) {
            $negociation->setStatus($data->status);
        }

        $this->em->flush();

        return $negociation;
    }
}
