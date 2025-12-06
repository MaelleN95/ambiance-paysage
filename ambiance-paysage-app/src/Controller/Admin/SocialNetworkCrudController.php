<?php

namespace App\Controller\Admin;

use App\Entity\SocialNetwork;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class SocialNetworkCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SocialNetwork::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('social_network.singular')
            ->setEntityLabelInPlural('social_network.plural');
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'social_network.name.label');

        yield TextareaField::new('icon', 'social_network.icon.label')
            ->setRequired(false)
            ->setHelp('social_network.icon.help');

        yield UrlField::new('link', 'social_network.link.label');
    }
}
