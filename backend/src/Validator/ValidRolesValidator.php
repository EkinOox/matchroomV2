<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ValidRolesValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ValidRoles) {
            throw new UnexpectedTypeException($constraint, ValidRoles::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_array($value)) {
            throw new UnexpectedValueException($value, 'array');
        }

        foreach ($value as $role) {
            if (!in_array($role, $constraint->validRoles, true)) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ role }}', $role)
                    ->setParameter('{{ validRoles }}', implode(', ', $constraint->validRoles))
                    ->addViolation();
            }
        }
    }
}
