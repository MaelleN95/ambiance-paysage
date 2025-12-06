<?php

namespace App\Controller\Admin;

use App\Entity\Schedule;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ScheduleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Schedule::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('schedule.singular')
            ->setEntityLabelInPlural('schedule.plural');
    }

    public function configureFields(string $pageName): iterable
    {
        yield ChoiceField::new('dayName', 'schedule.day_name.label')
            ->setChoices([
                'schedule.day_name.monday'    => 'Monday',
                'schedule.day_name.tuesday'   => 'Tuesday',
                'schedule.day_name.wednesday' => 'Wednesday',
                'schedule.day_name.thursday'  => 'Thursday',
                'schedule.day_name.friday'    => 'Friday',
                'schedule.day_name.saturday'  => 'Saturday',
                'schedule.day_name.sunday'    => 'Sunday',
            ]);

        yield ChoiceField::new('mode', 'schedule.mode.label')
            ->setChoices([
                'schedule.mode.closed'       => 'closed',
                'schedule.mode.open_all_day' => 'open',
                'schedule.mode.break'        => 'break',
            ]);

        yield TimeField::new('morningStart', 'schedule.morning_start.label')
            ->setRequired(false);
        yield TimeField::new('morningEnd', 'schedule.morning_end.label')
            ->setRequired(false);
        yield TimeField::new('afternoonStart', 'schedule.afternoon_start.label')
            ->setRequired(false);
        yield TimeField::new('afternoonEnd', 'schedule.afternoon_end.label')
            ->setRequired(false);
    }


    public function configureAssets(Assets $assets): Assets
    {
        $assets->addJsFile('controllers/opening_hours.js', Crud::PAGE_INDEX);
        return $assets;
    }
}
