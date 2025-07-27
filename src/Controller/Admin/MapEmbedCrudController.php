<?php

namespace App\Controller\Admin;

use App\Entity\MapEmbed;
use App\Repository\MapEmbedRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MapEmbedCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MapEmbed::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextareaField::new('iframe', 'Code Google Maps (iframe)')
                ->renderAsHtml()
                ->setHelp(<<<'HTML'
                    <div class="text-sm leading-relaxed text-gray-600">
                    <p class="mb-2"><strong>📍 Comment obtenir le code Google Maps ?</strong></p>
                    <ol class="list-decimal list-inside space-y-1">
                        <li>Va sur <a href="https://www.google.fr/maps" class="text-primary" target="_blank">Google Maps</a></li>
                        <li>Recherche ton adresse (ex. <em>1456 Route Départementale, 97630 Mtsamboro</em>).</li>
                        <li>Clique sur <strong>"Partager"</strong>, puis <strong>"Intégrer une carte"</strong>.</li>
                        <li>Clique sur <strong>"Copier le contenu HTML"</strong>.</li>
                        <li><strong>⚠️ Modifie width et height à <code>"100%"</code></strong> pour l’adapter à la taille de la page.</li>
                    </ol>
                    </div>
                    HTML),
        ];
    }

    /**
     * @Route("/admin/map-embed", name="admin_map_embed")
     */
    public function redirectToEdit(MapEmbedRepository $repo, AdminUrlGenerator $adminUrlGenerator): Response
    {
        $map = $repo->findOneBy([]);
        if (!$map) {
            throw $this->createNotFoundException("Carte Google Maps non définie.");
        }

        $url = $adminUrlGenerator
            ->setController(self::class)
            ->setAction('edit')
            ->setEntityId($map->getId())
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW , Action::DELETE);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('edit', 'Modifier la carte Google Maps')
            ->setEntityLabelInSingular('Carte Google Maps')
            ->setEntityLabelInPlural('Carte Google Maps');
    }
}
