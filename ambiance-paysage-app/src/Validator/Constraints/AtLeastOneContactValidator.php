<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use App\DTO\ContactData;

class AtLeastOneContactValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {

        if (!$value instanceof ContactData) {
            return;
        }

        $phone = $value->phone ?? null;
        $email = $value->email ?? null;

        if ((empty(trim($phone)) && empty(trim($email)))) {
            $this->context
                ->buildViolation($constraint->message)
                ->atPath('phone')
                ->addViolation();

            $this->context
                ->buildViolation($constraint->message)
                ->atPath('email')
                ->addViolation();
        }
    }
}
