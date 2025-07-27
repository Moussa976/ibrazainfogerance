<?php

namespace App\Controller\Admin;

use App\Entity\ReseauSocial;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ReseauSocialCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ReseauSocial::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),

            TextField::new('name', 'Nom du réseau'),

            TextField::new('url', 'Lien URL'),

            TextField::new('icon', 'Classe CSS (icône)') // exemple : 'fab fa-facebook'
                ->formatValue(function ($value, $entity) {
                    return $value 
                        ? sprintf('<i class="%s"></i> <small class="text-muted">%s</small>', $value, $value) 
                        : '';
                })
                ->onlyOnIndex()
                ->renderAsHtml(),

            TextField::new('icon', 'Classe CSS (icône)')->onlyWhenUpdating(),
            TextField::new('icon', 'Classe CSS (icône)')->onlyWhenCreating(),
        ];
    }
}
