<?php

namespace App\Tests\Unitary\Application\Port\out\Persistence\Database;

use App\Application\Port\out\Persistence\Database\GetProjectPort;
use App\Tests\Unitary\Domain\Project\ProjectTestBuilder;
use Exception;
use Mockery;


class GetProjectPortMockBuilder
{

    public static function getExceptionOnGet(): GetProjectPort
    {
        $mock = Mockery::mock(GetProjectPort::class);
        $mock->shouldReceive('get')->andThrow(Exception::class);

        return $mock;
    }

    public static function getDefault(): GetProjectPort
    {
        $mock = Mockery::mock(GetProjectPort::class);
        $mock->shouldReceive('get')->andReturn(ProjectTestBuilder::getDefaultPersistedProject());

        return $mock;
    }

    public static function getNull(): GetProjectPort
    {
        $mock = Mockery::mock(GetProjectPort::class);
        $mock->shouldReceive('get')->andReturn(null);

        return $mock;
    }
}