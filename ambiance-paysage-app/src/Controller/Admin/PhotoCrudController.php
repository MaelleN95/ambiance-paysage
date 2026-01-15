<?php

namespace App\Controller\Admin;

use App\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
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
            
        yield BooleanField::new('featuredOnHomepage', 'photo.featured_on_homepage.label')
            ->renderAsSwitch(true)
            ->setHelp('photo.featured_on_homepage.help')
            ->addCssClass('featured-on-homepage-switch');
    }

    public function persistEntity(EntityManagerInterface $em, $entityInstance): void
    {
        $this->setExclusiveFeatured($em, $entityInstance);
        parent::persistEntity($em, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $em, $entityInstance): void
    {
        $this->setExclusiveFeatured($em, $entityInstance);
        parent::updateEntity($em, $entityInstance);
    }

    private function setExclusiveFeatured(EntityManagerInterface $em, $entityInstance): void
    {
        if ($entityInstance->isFeaturedOnHomepage()) {
            $repo = $em->getRepository(Photo::class);
            $others = $repo->createQueryBuilder('b')
                ->where('b.id != :id')
                ->andWhere('b.featuredOnHomepage = true')
                ->setParameter('id', $entityInstance->getId() ?? 0)
                ->getQuery()
                ->getResult();

            foreach ($others as $other) {
                $other->setFeaturedOnHomepage(false);
            }
        }
    }

    public function configureAssets(Assets $assets): Assets
    {
        $assets->addJsFile('controllers/photo_listing.js', Crud::PAGE_INDEX);
        return $assets;
    }
}
