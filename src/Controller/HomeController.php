<?php

namespace App\Controller;

use App\Repository\CoordonneeRepository;
use App\Repository\MapEmbedRepository;
use App\Repository\PageContentRepository;
use App\Repository\ReseauSocialRepository;
use App\Repository\ServiceRepository;
use App\Repository\StatistiqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(ServiceRepository $serviceRepository, PageContentRepository $pageContentRepository, CoordonneeRepository $coordonneeRepository, StatistiqueRepository $statistiqueRepository, MapEmbedRepository $mapEmbedRepository, ReseauSocialRepository $reseauSocialRepository): Response
    {
        $services = $serviceRepository->findBy(['isPublished' => true]);
        $page = $pageContentRepository->findOneBy(['slug' => 'accueil']);
        $statistiques = $statistiqueRepository->findAll();
        $reseauxsociaux = $reseauSocialRepository->findAll();
        $mapembed = $mapEmbedRepository->findOneBy(['id' => '1']);

        
        $pageApropos = $pageContentRepository->findOneBy(['slug' => 'apropos']);
        /* affichage de 2 paragraphes*/
        $fullHtml = $pageApropos->getContent();
        // Supprimer toutes les balises <div> (ou <div ...>), qu'elles soient ouvertes ou fermées
        $cleanHtml = preg_replace('/<\/?div[^>]*>/i', '', $fullHtml);
        // Ensuite, découper sur ".<br>" (en gardant les séparateurs)
        $parts = preg_split('/(\.<br\s*\/?>)/i', $cleanHtml, -1, PREG_SPLIT_DELIM_CAPTURE);
        // Recomposer les 2 premières phrases terminées par .<br>
        $contenuApropos = '';
        $phraseCount = 0;
        foreach ($parts as $part) {
            $contenuApropos .= $part;
            if (preg_match('/\.<br\s*\/?>/i', $part)) {
                $phraseCount++;
                if ($phraseCount >= 2) {
                    break;
                }
            }
        }
        /* Fin */

        // Pour les coordonnées
        $coordonneesRaw = $coordonneeRepository->findAll();
        $coordonnees = [];
        foreach ($coordonneesRaw as $coordonnee) {
            $cleanValue = preg_replace('/<\/?div[^>]*>/i', '', $coordonnee->getValue());
            $coordonnees[] = [
                'type' => $coordonnee->getType(),
                'icon' => $coordonnee->getIcon(),
                'value' => $cleanValue,
            ];
        }

        return $this->render('pages/home.html.twig', [
            'services' => $services,
            'page' => $page,
            'contenuApropos' => $contenuApropos,
            'coordonnees' => $coordonnees,
            'statistiques' => $statistiques,
            'mapembed' => $mapembed,
            'reseauxsociaux' => $reseauxsociaux,
        ]);
    }
}
