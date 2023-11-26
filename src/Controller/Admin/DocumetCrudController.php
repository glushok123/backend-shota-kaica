<?php

namespace App\Controller\Admin;

use App\Entity\Documet;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DocumetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Documet::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('fond')
            ->add('opis')
            ->add('numberCase')
            ->add('userGroup')
            ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud


        // the number of pages to display on each side of the current page
        // e.g. if num pages = 35, current page = 7 and you set ->setPaginatorRangeSize(4)
        // the paginator displays: [Previous]  1 ... 3  4  5  6  [7]  8  9  10  11 ... 35  [Next]
        // set this number to 0 to display a simple "< Previous | Next >" pager
        ->setPaginatorPageSize(600);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setDisabled(),
            TextField::new('fond', 'Фонд')->setDisabled(),
            TextField::new('opis', 'Опись')->setDisabled(),
            TextField::new('numberCase', 'Дело')->setDisabled(),
            TextField::new('numberList', 'Листы'),
            TextField::new('name', 'Название'),
            TextField::new('anatation', 'Анатация'),
            TextField::new('geography', 'География'),
            TextField::new('nameFile', 'Название файла')->setDisabled(),
            TextField::new('userGroup', 'группа Пользователя'),

            AssociationField::new('ekdi1', 'ЕКДИ №1')
                ->autocomplete(),

            AssociationField::new('ekdi2', 'ЕКДИ №2')
                ->autocomplete(),

            AssociationField::new('ekdi3', 'ЕКДИ №3')
                ->autocomplete(),

            AssociationField::new('ekdi4', 'ЕКДИ №4')
                ->autocomplete(),
        ];
    }
}
