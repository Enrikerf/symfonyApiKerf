<?php

namespace App\Tests\Unitary\Application\Port\out\Persistence\Database;

use App\Application\Port\out\Persistence\Database\CreateProjectPort;
use App\Application\Port\out\Persistence\Database\GetProjectsByPort;
use App\Domain\Project\Project;
use App\Tests\Unitary\Domain\Project\ProjectTestBuilder;
use Mockery;
use Exception;


class GetProjectsByPortMockBuilder
{

    public static function getExceptionOnGetBy(): GetProjectsByPort
    {
        $mock = Mockery::mock(GetProjectsByPort::class);
        $mock->shouldReceive('getBy')->andThrow(Exception::class);

        return $mock;
    }

    public static function getArray(): GetProjectsByPort
    {
        $mock = Mockery::mock(GetProjectsByPort::class);
        $mock->shouldReceive('getBy')->andReturn([ProjectTestBuilder::getDefaultPersistedProject()]);

        return $mock;
    }


}