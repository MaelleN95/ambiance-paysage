<?php

namespace App\Controller\Admin;

use App\Entity\Photo;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PhotoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Photo::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield ImageField::new('image', 'Image')
            ->setBasePath('/uploads/photos')
            ->onlyOnIndex();

        yield Field::new('imageFile', 'Image')
            ->setFormType(VichImageType::class)
            ->onlyOnForms();

        yield ChoiceField::new('category')
            ->setChoices([
                'Work in progress' => 'work_in_progress',
                'Finished' => 'finished',
            ]);

    }


}
