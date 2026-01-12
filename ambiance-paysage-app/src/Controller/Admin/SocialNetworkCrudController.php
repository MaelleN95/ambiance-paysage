<?php

namespace App\Controller\Admin;

use App\Entity\SocialNetwork;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SocialNetworkCrudController extends AbstractCrudController
{
    public function __construct(
        private AuthorizationCheckerInterface $auth
    ) {}


    public static function getEntityFqcn(): string
    {
        return SocialNetwork::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('social_network.singular')
            ->setEntityLabelInPlural('social_network.plural')
            ->setEntityPermission('ROLE_ADMIN');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::NEW, 'ROLE_SUPER_ADMIN');
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'social_network.name.label');

        yield TextField::new('title', 'social_network.title.label')
            ->setHelp('social_network.title.help');

        yield BooleanField::new('isVisible', 'social_network.is_visible.label')
            ->setHelp('social_network.is_visible.help');

        if (
                $pageName === Crud::PAGE_EDIT
                && $this->auth->isGranted('ROLE_SUPER_ADMIN')
            ) {
                yield TextareaField::new('icon', 'social_network.icon.label')
                    ->setRequired(false)
                    ->onlyOnForms()
                    ->setHelp('social_network.icon.help');
            }

        yield UrlField::new('link', 'social_network.link.label');
    }
}
