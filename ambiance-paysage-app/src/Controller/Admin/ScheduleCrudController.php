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

    public function configureFields(string $pageName): iterable
    {
            yield ChoiceField::new('dayName', 'Day Name')
                ->setChoices([
                    'Monday'    => 'Monday',
                    'Tuesday'   => 'Tuesday',
                    'Wednesday' => 'Wednesday',
                    'Thursday'  => 'Thursday',
                    'Friday'    => 'Friday',
                    'Saturday'  => 'Saturday',
                    'Sunday'    => 'Sunday',
                ]);

            yield ChoiceField::new('mode')
                ->setChoices([
                    'Open' => 'open',
                    'Closed' => 'closed',
                    'Break' => 'break',
                ]);

            yield TimeField::new('morningStart', 'Day Start')
                ->setRequired(false);
            yield TimeField::new('morningEnd', 'Morning End')
                ->setRequired(false);
            yield TimeField::new('afternoonStart', 'Afternoon Start')
                ->setRequired(false);
            yield TimeField::new('afternoonEnd', 'Day End')
                ->setRequired(false);
    }


    public function configureAssets(Assets $assets): Assets
    {
        $assets->addJsFile('controllers/opening_hours.js', Crud::PAGE_INDEX);
        return $assets;
    }
}
