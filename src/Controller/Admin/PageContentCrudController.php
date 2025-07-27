<?php

namespace App\Controller\Admin;

use App\Entity\PageContent;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PageContentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PageContent::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title', 'Titre de la page'),
            SlugField::new('slug')->setTargetFieldName('title')->hideOnIndex(),
            TextField::new('subtitle', 'Sous-titre')->hideOnIndex(),
            TextField::new('contentTitle', 'Titre du contenu')->hideOnIndex(),

            ImageField::new('image')
                ->setBasePath('/uploads/pages')
                ->setUploadDir('public/uploads/pages')
                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                ->setRequired(false),


            TextEditorField::new('content', 'Contenu (texte HTML)'),
        ];
    }
}
