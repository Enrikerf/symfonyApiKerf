<?php

namespace App\Tests\Unitary\Application\Port\out\Persistence\Database;

use App\Application\Port\out\Persistence\Database\GetIssuePort;
use App\Tests\Unitary\Domain\Issue\IssueTestBuilder;
use Exception;
use Mockery;


class GetIssuePortMockBuilder
{

    public static function getExceptionOnGet(): GetIssuePort
    {
        $mock = Mockery::mock(GetIssuePort::class);
        $mock->shouldReceive('get')->andThrow(Exception::class);

        return $mock;
    }

    public static function getDefault(): GetIssuePort
    {
        $mock = Mockery::mock(GetIssuePort::class);
        $mock->shouldReceive('get')->andReturn(IssueTestBuilder::getDefaultPersisted());

        return $mock;
    }

    public static function getNull(): GetIssuePort
    {
        $mock = Mockery::mock(GetIssuePort::class);
        $mock->shouldReceive('get')->andReturn(null);

        return $mock;
    }
}