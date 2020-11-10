<?php

namespace App\Tests\Unitary\Application\Port\out\Persistence\Database;

use App\Application\Port\out\Persistence\Database\CreateProjectPort;
use App\Tests\Unitary\Domain\Project\ProjectTestBuilder;
use Mockery;
use Exception;

class CreateProjectPortMockBuilder
{

    public static function getReturnNullOnSave(): CreateProjectPort
    {
        $mock = Mockery::mock(CreateProjectPort::class);
        $mock->shouldReceive('save')->andReturn(null);

        return $mock;
    }

    public static function getReturnProjectPersistedOnSave(): CreateProjectPort
    {
        $mock = Mockery::mock(CreateProjectPort::class);
        $mock->shouldReceive('save')->andReturn(ProjectTestBuilder::getDefaultPersistedProject());

        return $mock;
    }

    public static function getReturnExceptionOnSave(): CreateProjectPort
    {
        $mock = Mockery::mock(CreateProjectPort::class);
        $mock->shouldReceive('save')->andThrow(Exception::class);

        return $mock;
    }
}