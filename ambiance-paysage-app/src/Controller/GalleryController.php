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


    #[Route('/galerie-photo/{category}/{page}', name: 'app_gallery_more', defaults: ['page' => 1])]
    public function more(string $category, int $page, PhotoRepository $photoRepository, BeforeAfterPhotoRepository $beforeAfterPhotoRepository): Response
    {

        $limit = 10;
        $offset = ($page - 1) * $limit;

        switch ($category) {
            case 'before_after':
                $photos = $beforeAfterPhotoRepository->findPaginated($limit, $offset);
                $total = $beforeAfterPhotoRepository->count([]);
                break;

            case 'work_in_progress':
                $photos = $photoRepository->findByCategoryPaginated('work_in_progress', $limit, $offset);
                $total = $photoRepository->count(['category' => 'work_in_progress']);
                break;

            case 'finished':
                $photos = $photoRepository->findByCategoryPaginated('finished', $limit, $offset);
                $total = $photoRepository->count(['category' => 'finished']);
                break;

            default:
                throw $this->createNotFoundException('Catégorie invalide');
        }

        return $this->render('gallery/more.html.twig', [
            'photos' => $photos,
            'category' => $category,
            'page' => $page,
            'total_pages' => ceil($total / $limit),
        ]);
    }



}
