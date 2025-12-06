<?php

namespace App\Validator\Constraints;

use App\Entity\Schedule;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ValidScheduleValidator extends ConstraintValidator
{
    public function validate($schedule, Constraint $constraint)
    {
        if (!$schedule instanceof Schedule) {
            return;
        }

        $mode = $schedule->getMode();

        switch ($mode) {
            case 'open':
                $this->getErrorsForOpenMode($schedule);
                break;

            case 'closed':
                $this->getErrorsForClosedMode($schedule);
                break;

            case 'break':
                $this->getErrorsForBreakMode($schedule);
                break;

            default:
                break;
        }
    }

    /* 
    * Validation rules for 'break' mode:
    * - morningStart must be before morningEnd
    * - morningEnd must be before afternoonStart
    * - afternoonStart must be before afternoonEnd
    */
    private function getErrorsForBreakMode(Schedule $schedule): void
    {
        if (
            $schedule->getMorningStart() && $schedule->getMorningEnd() &&
            $schedule->getMorningStart() > $schedule->getMorningEnd()
        ) {
            $this->context->buildViolation('Le début de la journée doit être avant la fin de la matinée')
                ->atPath('morningStart')
                ->addViolation();
        }

        if (
            $schedule->getMorningEnd() && $schedule->getAfternoonStart() &&
            $schedule->getMorningEnd() > $schedule->getAfternoonStart()
        ) {
            $this->context->buildViolation('La fin de la matinée doit être avant le début de l\'après-midi')
                ->atPath('morningEnd')
                ->addViolation();
        }

        if (
            $schedule->getAfternoonStart() && $schedule->getAfternoonEnd() &&
            $schedule->getAfternoonStart() > $schedule->getAfternoonEnd()
        ) {
            $this->context->buildViolation('Le début de l\'après-midi doit être avant la fin de la journée')
                ->atPath('afternoonStart')
                ->addViolation();
        }
    }

    /* 
    * Validation rules for 'open' mode:
    * - morningStart and afternoonEnd must be defined
    * - morningStart must be before afternoonEnd
    * - morningEnd and afternoonStart must be null
    */
    private function getErrorsForOpenMode(Schedule $schedule): void
    {
        if ($schedule->getMorningStart() && $schedule->getAfternoonEnd()) {
            if ($schedule->getMorningStart() > $schedule->getAfternoonEnd()) {
                $this->context->buildViolation('Le début de la journée doit être avant la fin de la journée')
                    ->atPath('morningStart')
                    ->addViolation();
            }
        } else {
            if (!$schedule->getMorningStart()) {
                $this->context->buildViolation('Le début de la journée doit être définie lorsque le jour est ouvert.')
                    ->atPath('morningStart')
                    ->addViolation();
            }
            if (!$schedule->getAfternoonEnd()) {
                $this->context->buildViolation('la fin de la journée doit être définie lorsque le jour est ouvert.')
                    ->atPath('afternoonEnd')
                    ->addViolation();
            }
        }
        foreach (['morningEnd', 'afternoonStart'] as $prop) {
            if ($schedule->{'get' . ucfirst($prop)}()) {
                $this->context->buildViolation("Ce champ doit être vide lorsque le jour est ouvert sans pause.")
                    ->atPath($prop)
                    ->addViolation();
            }
        }
    }

    /* 
    * Validation rules for 'closed' mode:
    * - all time properties must be null
    */
    private function getErrorsForClosedMode(Schedule $schedule): array
    {
        $errors = [];

        foreach (['morningStart', 'morningEnd', 'afternoonStart', 'afternoonEnd'] as $prop) {
            if ($schedule->{'get' . ucfirst($prop)}()) {
                $this->context->buildViolation("$prop doit être vide lorsque le jour est fermé.")
                    ->atPath($prop)
                    ->addViolation();
            }
        }

        return $errors;
    }
}
