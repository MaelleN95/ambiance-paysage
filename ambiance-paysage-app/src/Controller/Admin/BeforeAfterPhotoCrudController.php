<?php

namespace App\Controller\Admin;

use App\Entity\BeforeAfterPhoto;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BeforeAfterPhotoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BeforeAfterPhoto::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('before_after.singular')
            ->setEntityLabelInPlural('before_after.plural');
    }

    public function configureFields(string $pageName): iterable
    {
        yield ImageField::new('beforeImage', 'before_after.before_image.label')
            ->setBasePath('/uploads/before_after')
            ->onlyOnIndex();

        yield ImageField::new('afterImage', 'before_after.after_image.label')
            ->setBasePath('/uploads/before_after')
            ->onlyOnIndex();

        yield Field::new('beforeImageFile', 'before_after.before_image.label')
            ->setFormType(VichImageType::class)
            ->onlyOnForms();

        yield Field::new('afterImageFile', 'before_after.after_image.label')
            ->setFormType(VichImageType::class)
            ->onlyOnForms();
    }
}
