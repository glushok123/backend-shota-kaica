<?php

namespace App\Controller\Admin;

use App\Entity\Documet;
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


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('fond', 'Фонд'),
            TextField::new('opis', 'Опись'),
            TextField::new('numberCase', 'Дело'),
            TextField::new('numberList', 'Листы'),
            TextField::new('name', 'Название'),
            TextField::new('anatation', 'Анатация'),
            TextField::new('geography', 'География'),
            TextField::new('nameFile', 'Название файла'),

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
