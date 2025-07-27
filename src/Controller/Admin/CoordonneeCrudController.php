<?php

namespace App\Controller\Admin;

use App\Entity\Coordonnee;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CoordonneeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Coordonnee::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),

            TextField::new('type', 'Type de donnée (ex : Téléphone, Email)'),
            TextEditorField::new('value', 'Valeur (ex : 06 00 00 00 00 ou contact@site.fr)'),

            TextField::new('icon', 'Classe CSS (ex : fas fa-phone)')
                ->formatValue(function ($value, $entity) {
                    return $value
                        ? sprintf('<i class="%s"></i> <small class="text-muted">%s</small>', $value, $value)
                        : '';
                })
                ->onlyOnIndex()
                ->renderAsHtml(),

            // Champ d’édition visible uniquement dans les formulaires
            TextField::new('icon', 'Icône CSS')->onlyWhenCreating(),
            TextField::new('icon', 'Icône CSS')->onlyWhenUpdating(),
        ];
    }
}
