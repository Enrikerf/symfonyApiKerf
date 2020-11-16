<?php

namespace App\Tests\Unitary\Application\Port\out\Persistence\Database;

use App\Application\Port\out\Persistence\Database\CreateProjectPort;
use App\Domain\Project\Project;
use App\Tests\Unitary\Domain\Project\ProjectTestBuilder;
use Mockery;
use Exception;


class CreateProjectPortMockBuilder
{

    public static function getReturnProjectPersistedOnSave(): CreateProjectPort
    {
        $mock = Mockery::mock(CreateProjectPort::class);
        $mock->shouldReceive('save')->with(Mockery::on(function (Project $project) {
            $project->setId(ProjectTestBuilder::DEFAULT_PROJECT_ID);

            return true;
        }))->andReturn(null);

        return $mock;
    }

    public static function getReturnExceptionOnSave(): CreateProjectPort
    {
        $mock = Mockery::mock(CreateProjectPort::class);
        $mock->shouldReceive('save')->andThrow(Exception::class);

        return $mock;
    }
}