<?php

namespace App\Enums\Users;

use App\Enums\Enumable;

class Roles
{
    use Enumable;

    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_USER = 'ROLE_USER';
}