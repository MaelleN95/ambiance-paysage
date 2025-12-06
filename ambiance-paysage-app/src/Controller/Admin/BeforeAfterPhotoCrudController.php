<?php

namespace App\Controller\Admin;

use App\Entity\BeforeAfterPhoto;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BeforeAfterPhotoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BeforeAfterPhoto::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield FormField::addPanel('Before/After Images');

        yield ImageField::new('beforeImage', 'Before Image')
            ->setBasePath('/uploads/before_after')
            ->onlyOnIndex();

        yield ImageField::new('afterImage', 'After Image')
            ->setBasePath('/uploads/before_after')
            ->onlyOnIndex();

        yield Field::new('beforeImageFile', 'Before Image')
            ->setFormType(VichImageType::class)
            ->onlyOnForms();

        yield Field::new('afterImageFile', 'After Image')
            ->setFormType(VichImageType::class)
            ->onlyOnForms();

        yield BooleanField::new('featuredOnHomepage')
            ->renderAsSwitch(true)
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
            $repo = $em->getRepository(BeforeAfterPhoto::class);
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
        $assets->addJsFile('controllers/before_after_listing.js', Crud::PAGE_INDEX);
        return $assets;
    }

}
