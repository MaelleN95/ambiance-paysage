<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('service.singular')
            ->setEntityLabelInPlural('service.plural');
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'service.name.label');
        
        yield BooleanField::new('prioritized', 'service.prioritized.label')
            ->setHelp('service.prioritized.help');

        yield Field::new('imageFile', 'service.image.label')
            ->setFormType(VichImageType::class)
            ->onlyOnForms();

        if ($this->isGranted('ROLE_SUPER_ADMIN')) {

            yield TextareaField::new('icon', 'service.icon.label')
                ->setRequired(false)
                ->setHelp('service.icon.help')
                ->onlyOnForms();
        }
    }
}
