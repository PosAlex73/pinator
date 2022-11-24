<?php

namespace App\Enums;

trait Enumable
{
    public static function getAll()
    {
        $reflection = new \ReflectionClass(static::class);

        return $reflection->getConstants();
    }
}
