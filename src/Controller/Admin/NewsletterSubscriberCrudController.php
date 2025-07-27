<?php

namespace App\Controller\Admin;

use App\Entity\NewsletterSubscriber;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;

class NewsletterSubscriberCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return NewsletterSubscriber::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            EmailField::new('email', 'Adresse e-mail'),
            DateTimeField::new('createdAt', 'Inscrit le')->setFormat('dd/MM/yyyy à HH:mm'),
        ];
    }
}
