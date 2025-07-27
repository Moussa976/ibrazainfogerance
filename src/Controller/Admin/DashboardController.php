<?php

namespace App\Controller\Admin;

use App\Entity\NewsletterSubscriber;
use App\Entity\Service;
use App\Entity\PageContent;
use App\Entity\Statistique;
use App\Entity\Coordonnee;
use App\Entity\ReseauSocial;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        // Redirection vers Service par défaut
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(ServiceCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Ibraza Admin')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Tableau de bord', 'fa fa-home');

        yield MenuItem::section('Gestion du site');
        yield MenuItem::linkToCrud('Services', 'fas fa-cogs', Service::class);
        yield MenuItem::linkToCrud('Pages', 'fas fa-file-alt', PageContent::class);
        yield MenuItem::linkToCrud('Statistiques', 'fas fa-chart-bar', Statistique::class);
        yield MenuItem::linkToCrud('Coordonnées', 'fas fa-map-marker-alt', Coordonnee::class);
        yield MenuItem::linkToCrud('Réseaux sociaux', 'fab fa-facebook', ReseauSocial::class);
        yield MenuItem::linkToRoute('Carte Google Maps', 'fas fa-map', 'admin_map_embed');
        yield MenuItem::section('Utilisateurs');
        yield MenuItem::linkToCrud('Comptes', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Newsletter', 'fas fa-envelope-open-text', NewsletterSubscriber::class);
    }
}
