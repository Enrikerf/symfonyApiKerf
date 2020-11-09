<?php

namespace App\Tests\Unitary\Adapter\out\Serializer;

use App\Adapter\out\Serializer\SymfonySerializer;
use Mockery;


class SymfonySerializerBuilder
{

    public static function get()
    {
        return (new SymfonySerializer());
    }

    public static function getMockWithDenormalizeReturnNull()
    {
        $serializerMock = Mockery::mock(SymfonySerializer::class);
        $serializerMock->shouldReceive('denormalize')
            ->andReturn(null);

        return $serializerMock;
    }
}