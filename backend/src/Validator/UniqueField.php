<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::IS_REPEATABLE)]
class UniqueField extends Constraint
{
    public string $entityClass;
    public string $field;
    public string $message = 'Cette valeur est déjà utilisée.';

    public function __construct(
        array $options = [],
        ?string $entityClass = null,
        ?string $field = null,
        ?string $message = null,
        mixed $groups = null,
        mixed $payload = null
    ) {
        parent::__construct($options, $groups, $payload);

        $this->entityClass = $entityClass ?? $options['entityClass'] ?? throw new \InvalidArgumentException('Missing option "entityClass"');
        $this->field = $field ?? $options['field'] ?? throw new \InvalidArgumentException('Missing option "field"');
        $this->message = $message ?? $options['message'] ?? $this->message;
    }

    public function getTargets(): string
    {
        return self::PROPERTY_CONSTRAINT;
    }
}
