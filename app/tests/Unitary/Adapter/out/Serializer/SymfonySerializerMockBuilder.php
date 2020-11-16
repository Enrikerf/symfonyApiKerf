<?php

namespace App\Tests\Unitary\Adapter\out\Serializer;

use App\Adapter\out\Persistence\Doctrine\Adapter\ProjectPersistenceAdapter;
use App\Adapter\out\Serializer\SymfonySerializer;
use Mockery;


class SymfonySerializerMockBuilder
{



    public static function getMockWithDenormalizeReturnNull()
    {
        $serializerMock = Mockery::mock(SymfonySerializer::class);
        $serializerMock->shouldReceive('denormalize')
            ->andReturn(null);

        return $serializerMock;
    }
    public static function getExceptionOnDenormalize()
    {
        $serializerMock = Mockery::mock(SymfonySerializer::class);
        $serializerMock->shouldReceive('denormalize')
            ->andThrow(\Exception::class);

        return $serializerMock;
    }
}