<?php

namespace App\Controller\Admin;

use App\Entity\DiaryPost;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class DiaryPostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DiaryPost::class;
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
