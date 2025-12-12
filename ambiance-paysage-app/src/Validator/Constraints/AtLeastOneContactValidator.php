<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AtLeastOneContactValidator extends ConstraintValidator
{
    /**
     * $value = data du formulaire (un array car pas d’entité)
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!is_array($value)) {
            return;
        }

        $phone = $value['phone'] ?? null;
        $email = $value['email'] ?? null;

        if (
            (empty($phone) || trim($phone) === '') &&
            (empty($email) || trim($email) === '')
        ) {
            $this->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
