<?php

namespace App\Controller;

use App\Repository\BeforeAfterPhotoRepository;
use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GalleryController extends AbstractController
{
    #[Route('/galerie-photo', name: 'app_gallery')]
    public function index(BeforeAfterPhotoRepository $beforeAfterPhotoRepository, PhotoRepository $photoRepository): Response
    {

        $beforeAfterPhotosList = $beforeAfterPhotoRepository->findLast(4);
        $workInProgress = $photoRepository->findByCategoryLast('work_in_progress', 4);
        $finished = $photoRepository->findByCategoryLast('finished', 4);

        return $this->render('gallery/index.html.twig', [
            'beforeAfterPhotosList' => $beforeAfterPhotosList,
            'workInProgress' => $workInProgress,
            'finished' => $finished,
        ]);
    }
}
