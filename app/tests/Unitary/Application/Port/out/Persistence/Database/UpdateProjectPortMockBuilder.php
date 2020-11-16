<?php

namespace App\Tests\Unitary\Application\Port\out\Persistence\Database;

use App\Application\Port\out\Persistence\Database\UpdateProjectPort;
use App\Domain\Project\Project;
use App\Tests\Unitary\Domain\Project\ProjectTestBuilder;
use Exception;
use Mockery;


class UpdateProjectPortMockBuilder
{

    public static function getReturnProjectPersistedOnUpdate(): UpdateProjectPort
    {
        $mock = Mockery::mock(UpdateProjectPort::class);
        $mock->shouldReceive('get')->andReturn(ProjectTestBuilder::getDefaultPersistedProject());
        $mock->shouldReceive('update')->with(Mockery::on(function (Project $project) {
            $project->setId(ProjectTestBuilder::DEFAULT_PROJECT_ID);

            return true;
        }))->andReturn(null);

        return $mock;
    }

    public static function getReturnExceptionOnUpdate(): UpdateProjectPort
    {
        $mock = Mockery::mock(UpdateProjectPort::class);
        $mock->shouldReceive('update')->andThrow(Exception::class);

        return $mock;
    }
}