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
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
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
            ->setTitle('Html');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::linkToCrud('Before/After Photos', 'fa fa-images', BeforeAfterPhoto::class);
        yield MenuItem::linkToCrud('Photos', 'fa fa-image', Photo::class);
        yield MenuItem::linkToCrud('Services', 'fa fa-tools', Service::class);
        yield MenuItem::linkToCrud('Schedules', 'fa fa-clock', Schedule::class);
        yield MenuItem::linkToCrud('Social Networks', 'fa fa-share-alt', SocialNetwork::class);
        yield MenuItem::linkToCrud('About', 'fa fa-info-circle', About::class);
    }
}
