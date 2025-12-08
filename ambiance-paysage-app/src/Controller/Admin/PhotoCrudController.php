<?php

namespace App\Controller\Admin;

use App\Entity\Photo;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PhotoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Photo::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('photo.singular')
            ->setEntityLabelInPlural('photo.plural');
    }


    public function configureFields(string $pageName): iterable
    {
        yield ImageField::new('image', 'photo.image.label')
            ->setBasePath('/uploads/photos')
            ->onlyOnIndex();

        yield Field::new('imageFile', 'photo.image.label')
            ->setFormType(VichImageType::class)
            ->onlyOnForms();

        yield ChoiceField::new('category', 'photo.category.label')
            ->setChoices([
                'photo.category.work_in_progress' => 'work_in_progress',
                'photo.category.finished' => 'finished',
            ]);
    }
}
