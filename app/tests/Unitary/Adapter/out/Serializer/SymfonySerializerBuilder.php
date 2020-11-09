<?php

namespace App\Tests\Unitary\Adapter\out\Serializer;

use App\Adapter\out\Serializer\SymfonySerializer;


class SymfonySerializerBuilder
{

    public static function get()
    {
        return (new SymfonySerializer());
    }
}