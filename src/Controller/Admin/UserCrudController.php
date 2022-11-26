<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Enums\Users\Roles;
use App\Enums\Users\UserStatuses;
use App\Enums\Users\UserTypes;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Core\Role\Role;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            EmailField::new('email'),
            ArrayField::new('roles'),
            ChoiceField::new('status')->setChoices(UserStatuses::getAll()),
            ChoiceField::new('type')->setChoices(UserTypes::getAll())
        ];
    }
}
