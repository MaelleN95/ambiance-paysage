<?php

namespace App\Controller\Admin;

use App\Entity\About;
use App\Entity\Photo;
use App\Entity\Service;
use App\Entity\Schedule;
use App\Entity\SocialNetwork;
use App\Entity\BeforeAfterPhoto;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

#[AdminDashboard(routePath: '/ap-admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect(
            $adminUrlGenerator
                ->setController(PhotoCrudController::class)
                ->generateUrl()
        );
    }
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Ambiance Paysage Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('dashboard.administration');
        yield MenuItem::linkToCrud('before_after.plural', 'fa fa-images', BeforeAfterPhoto::class);
        yield MenuItem::linkToCrud('photo.plural', 'fa fa-image', Photo::class);
        yield MenuItem::linkToCrud('service.plural', 'fa fa-tools', Service::class);
        yield MenuItem::linkToCrud('schedule.plural', 'fa fa-clock', Schedule::class);
        yield MenuItem::linkToCrud('social_network.plural','fa fa-share-alt',SocialNetwork::class);
        yield MenuItem::linkToCrud('about.singular', 'fa fa-info-circle', About::class);

        yield MenuItem::section('dashboard.nav');
        yield MenuItem::linkToUrl(
            'dashboard.home',
            'fa fa-globe',
            $this->generateUrl('app_homepage', [], UrlGeneratorInterface::ABSOLUTE_URL)
        );
    }
}
