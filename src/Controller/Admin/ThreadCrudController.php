<?php

namespace App\Controller\Admin;

use App\Entity\Thread;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ThreadCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Thread::class;
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
