<?php

namespace App\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class UniqueFieldValidator extends ConstraintValidator
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof UniqueField) {
            throw new UnexpectedTypeException($constraint, UniqueField::class);
        }

        if (null === $value || '' === $value) {
            return; // ne pas valider les champs vides
        }

        $repository = $this->em->getRepository($constraint->entityClass);

        $existing = $repository->findOneBy([
            $constraint->field => $value
        ]);

        if ($existing !== null) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
