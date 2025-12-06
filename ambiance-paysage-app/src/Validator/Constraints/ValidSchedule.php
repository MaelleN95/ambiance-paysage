<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class ValidSchedule extends Constraint
{
    public string $message = 'Les horaires ne sont pas cohérents.';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
