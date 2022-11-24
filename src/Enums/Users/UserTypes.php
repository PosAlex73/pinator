<?php

namespace App\Enums\Users;

use App\Enums\Enumable;

class UserTypes
{
    use Enumable;

    public const ADMIN = 'A';
    public const USER = 'U';
    public const MODERATOR = 'M';
}