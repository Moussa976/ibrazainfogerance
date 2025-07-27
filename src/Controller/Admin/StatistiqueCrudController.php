<?php

namespace App\Controller\Admin;

use App\Entity\Statistique;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class StatistiqueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Statistique::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('label', 'Nom de la statistique (Clients satisfaits, Interventions/an, ...)'),
            IntegerField::new('value', 'Valeur'),
        ];
    }
}
