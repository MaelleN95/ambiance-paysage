<?php

namespace App\Controller;

use App\Repository\AboutRepository;
use App\Repository\BeforeAfterPhotoRepository;
use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(ServiceRepository $serviceRepository, AboutRepository $aboutRepository, BeforeAfterPhotoRepository $beforeAfterPhotoRepository): Response
    {
        $prioritizedServices = $serviceRepository->findPrioritized();
        $otherServices = $serviceRepository->findNonPrioritized();
        $photosFeaturedOnHomePage = $beforeAfterPhotoRepository->findFeaturedOnHomepageBeforeAfterPhotos();

        $about = $aboutRepository->getSiteAbout();

        return $this->render('home/index.html.twig', [
            'prioritizedServices' => $prioritizedServices,
            'otherServices' => $otherServices,
            'photosFeaturedOnHomePage' => $photosFeaturedOnHomePage,
            'description' => $about?->getDescription(),
            'slogan' => $about?->getSlogan(),
        ]);
    }   
}
