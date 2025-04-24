<?php

namespace App\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class ValidRoles extends Constraint
{
    public string $message = 'Le rôle "{{ role }}" n\'est pas valide. Les rôles valides sont : {{ validRoles }}';
    public array $validRoles = ['ROLE_USER', 'ROLE_ADMIN'];

    public function __construct(
        ?array $validRoles = null,
        ?string $message = null,
        ?array $groups = null,
        $payload = null
    ) {
        parent::__construct([], $groups, $payload);

        $this->validRoles = $validRoles ?? $this->validRoles;
        $this->message = $message ?? $this->message;
    }
}
