<?php

namespace App\Tests\Unitary\Application\Port\out\Persistence\Database;

use App\Application\Port\out\Persistence\Database\GetProjectIssuePort;
use App\Tests\Unitary\Domain\Issue\IssueTestBuilder;
use App\Tests\Unitary\Domain\Project\ProjectTestBuilder;
use Exception;
use Mockery;


class GetProjectIssuePortMockBuilder
{

    public static function getExceptionOnGet(): GetProjectIssuePort
    {
        $mock = Mockery::mock(GetProjectIssuePort::class);
        $mock->shouldReceive('get')->andThrow(Exception::class);

        return $mock;
    }

    public static function getDefault(): GetProjectIssuePort
    {
        $mock = Mockery::mock(GetProjectIssuePort::class);
        $mock->shouldReceive('get')->andReturn([IssueTestBuilder::getDefaultNew()]);

        return $mock;
    }

    public static function getDefaultPersisted(): GetProjectIssuePort
    {
        $mock = Mockery::mock(GetProjectIssuePort::class);
        $mock->shouldReceive('get')->andReturn(IssueTestBuilder::getDefaultNew());

        return $mock;
    }

    public static function getEmpty(): GetProjectIssuePort
    {
        $mock = Mockery::mock(GetProjectIssuePort::class);
        $mock->shouldReceive('get')->andReturn([]);

        return $mock;
    }
}