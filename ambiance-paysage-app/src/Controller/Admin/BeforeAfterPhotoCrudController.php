<?php

namespace App\Controller\Admin;

use App\Entity\BeforeAfterPhoto;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
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

        yield BooleanField::new('featuredOnHomepage', 'before_after.featured_on_homepage.label')
            ->renderAsSwitch(true)
            ->setHelp('before_after.featured_on_homepage.help')
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
