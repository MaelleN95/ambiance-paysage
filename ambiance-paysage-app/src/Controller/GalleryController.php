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


    #[Route('/galerie-photo/{category}', name: 'app_gallery_more')]
    public function more(string $category, PhotoRepository $photoRepository, BeforeAfterPhotoRepository $beforeAfterPhotoRepository): Response
    {
        switch ($category) {
            case 'before_after':
                $photos = $beforeAfterPhotoRepository->findAllOrdered();
                break;

            case 'work_in_progress':
                $photos = $photoRepository->findByCategoryOrdered('work_in_progress');
                break;

            case 'finished':
                $photos = $photoRepository->findByCategoryOrdered('finished');
                break;

            default:
                throw $this->createNotFoundException('Catégorie invalide');
        }

        return $this->render('gallery/more.html.twig', [
            'photos' => $photos,
            'category' => $category,
        ]);
    }



}
