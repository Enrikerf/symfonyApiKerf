<?php

namespace App\Tests\Unitary\Adapter\out\Serializer;

use App\Adapter\out\Serializer\SymfonySerializer;


class SymfonySerializerTestBuilder
{

    public static function get()
    {
        return (new SymfonySerializer());
    }
}