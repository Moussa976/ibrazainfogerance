<?php

namespace App\Controller;

use App\Repository\PageContentRepository;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(ServiceRepository $serviceRepository, PageContentRepository $pageContentRepository): Response
    {
        $services = $serviceRepository->findBy(['isPublished'=>true]);
        $page = $pageContentRepository->findOneBy(['slug'=>'accueil']);
        return $this->render('pages/home.html.twig', [
            'services' => $services,
            'page' => $page,
        ]);
    }
}
