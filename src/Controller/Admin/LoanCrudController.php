<?php

namespace App\Controller\Admin;

use App\Entity\Loan;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LoanCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Loan::class;
    }

    public function configureCrud(Crud $crud): crud
    {
        return $crud
            ->setEntityLabelInPlural('Prêts')
            ->setEntityLabelInSingular('Prêt')
            ->setPageTitle("index","Chapelle-Curreaux / Administration des Prêts des Utilisateurs")
            ->setPaginatorPageSize(20)
            ->setSearchFields(['users.lastname']);
    }

    public function configureFields(string $pageName): iterable
    {
        if( Crud::PAGE_NEW === $pageName ){
            return [
                IdField::new('id')
                    ->hideOnForm(),
                AssociationField::new('users', 'Utilisateur'),
                AssociationField::new('book', 'Livre'),
                DateField::new('date_reserved', 'date de réservation')
                    ->setFormTypeOption('disabled', 'disabled'),
                DateField::new('date_loan', 'date du prêt')
                ->hideOnForm()
                ->setFormTypeOption('disabled', 'disabled'),
                DateField::new('date_return', 'date de retour')
                ->hideOnForm()
                ->setFormTypeOption('disabled', 'disabled'),
                TextField::new('status'),
                BooleanField::new('is_late', 'Retard'),
    
            ];




        }

    
        return [
            IdField::new('id')
                ->hideOnForm(),
            AssociationField::new('users', 'Utilisateur')
                ->setFormTypeOption('disabled', 'disabled'),
            AssociationField::new('book', 'Livre')
                ->setFormTypeOption('disabled', 'disabled'),
            DateField::new('date_reserved', 'date de réservation')
                ->setFormTypeOption('disabled', 'disabled'),
            DateField::new('date_loan', 'date du prêt')
                ->setFormTypeOption('required', 'required'),
            DateField::new('date_return', 'date de retour')
                ->setFormTypeOption('required', 'required'),
            TextField::new('status'),
            BooleanField::new('is_late', 'Retard'),

        ];

        
    }

    public function persistEntity(EntityManagerInterface $manager, $entityInstance): void
    {
        if(!$entityInstance instanceof Loan) return;

        $entityInstance->getBook()->setNbOfBook($entityInstance->getBook()->getNbOfBook() -1 );

        parent::persistEntity($manager, $entityInstance);

    }

    public function deleteEntity(EntityManagerInterface $manager, $entityInstance): void
    {
        if(!$entityInstance instanceof Loan) return;

        $entityInstance->getBook()->setNbOfBook($entityInstance->getBook()->getNbOfBook() +1 );

        parent::deleteEntity($manager, $entityInstance);

    }
    
    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
