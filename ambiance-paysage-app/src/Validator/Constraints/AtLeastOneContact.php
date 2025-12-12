<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_CLASS)]
class AtLeastOneContact extends Constraint
{
    public string $message = 'Vous devez renseigner au moins un moyen de contact : téléphone ou email.';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
