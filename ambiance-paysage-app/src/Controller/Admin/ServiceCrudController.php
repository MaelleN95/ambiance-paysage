<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
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

    public function configureFields(string $pageName): iterable
    {
            yield TextField::new('name');

            # @TODO : SUPER ADMIN ONLY
            yield BooleanField::new('prioritized')
                ->onlyOnForms();

            # @TODO : SUPER ADMIN ONLY
            yield Field::new('imageFile', 'Image')
                ->setFormType(VichImageType::class)
                ->onlyOnForms();

            # @TODO : SUPER ADMIN ONLY
            yield TextareaField::new('icon')
                ->setRequired(false)
                ->onlyOnForms();


    }
}
