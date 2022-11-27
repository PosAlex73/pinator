<?php

namespace App\Controller\Admin;

use App\Entity\Diary;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class DiaryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Diary::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            AssociationField::new('dairy_user'),

        ];
    }
}
