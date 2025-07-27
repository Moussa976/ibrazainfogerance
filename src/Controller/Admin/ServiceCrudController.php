<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;

class ServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre du service'),
            SlugField::new('slug')->setTargetFieldName('title')->hideOnIndex(),

            TextField::new('icon', 'Icône CSS')
                ->onlyOnForms()
                ->setHelp('Classe Font Awesome, ex : fa-solid fa-laptop'),
            TextareaField::new('shortDescription', 'Description courte'),
            TextEditorField::new('longDescription', 'Description complète'),

            BooleanField::new('isPublished', 'Publié ?'),

            ImageField::new('image')
                ->setBasePath('/uploads/services')
                ->setUploadDir('public/uploads/services')
                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                ->setRequired(false),
        ];
    }
}
