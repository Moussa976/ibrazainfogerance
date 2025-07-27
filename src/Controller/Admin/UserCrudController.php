<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Core\Security;

class UserCrudController extends AbstractCrudController
{
    private $passwordHasher;
    private $security;

    public function __construct(UserPasswordHasherInterface $passwordHasher, Security $security)
    {
        $this->passwordHasher = $passwordHasher;
        $this->security = $security;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setEntityLabelInPlural('Utilisateurs')
                    ->setEntityLabelInSingular('Utilisateur');
    }

    public function configureActions(Actions $actions): Actions
    {
        if (!$this->security->isGranted('ROLE_SUPER_ADMIN')) {
            return $actions
                ->disable(Action::NEW, Action::EDIT, Action::DELETE);
        }

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            EmailField::new('email', 'Adresse email'),
        ];

        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            $fields[] = ChoiceField::new('roles', 'Rôles')
                ->allowMultipleChoices()
                ->renderExpanded()
                ->setChoices([
                    'Administrateur' => 'ROLE_ADMIN',
                    'Super Admin' => 'ROLE_SUPER_ADMIN',
                ]);
        }

        // Ajout du champ mot de passe uniquement en création ou modification
        if (in_array($pageName, [Crud::PAGE_NEW, Crud::PAGE_EDIT])) {
            $fields[] = TextField::new('plainPassword', 'Mot de passe')
                ->onlyOnForms()
                ->setFormType(PasswordType::class)
                ->setHelp('Laisser vide pour ne pas modifier le mot de passe');
        }

        return $fields;
    }

    public function persistEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if ($entityInstance instanceof User && $entityInstance->getPlainPassword()) {
            $entityInstance->setPassword(
                $this->passwordHasher->hashPassword($entityInstance, $entityInstance->getPlainPassword())
            );
        }
        parent::persistEntity($em, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if ($entityInstance instanceof User && $entityInstance->getPlainPassword()) {
            $entityInstance->setPassword(
                $this->passwordHasher->hashPassword($entityInstance, $entityInstance->getPlainPassword())
            );
        }
        parent::updateEntity($em, $entityInstance);
    }
}
