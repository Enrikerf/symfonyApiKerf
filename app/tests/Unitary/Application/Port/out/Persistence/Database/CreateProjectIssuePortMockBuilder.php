<?php

namespace App\Tests\Unitary\Application\Port\out\Persistence\Database;

use App\Application\Port\out\Persistence\Database\CreateProjectIssuePort;
use App\Application\Port\out\Persistence\Database\CreateProjectPort;
use App\Domain\Issue\Issue;
use App\Domain\Project\Project;
use App\Tests\Unitary\Domain\Issue\IssueTestBuilder;
use App\Tests\Unitary\Domain\Project\ProjectTestBuilder;
use Mockery;
use Exception;


class CreateProjectIssuePortMockBuilder
{

    public static function getTopicTypeParentOnGetAndDefaultIssuePersistedOnSave(): CreateProjectIssuePort
    {
        $mock = Mockery::mock(CreateProjectIssuePort::class);
        $mock->shouldReceive('get')->andReturn(IssueTestBuilder::getDefaultTypeTopic());
        $mock->shouldReceive('save')->with(Mockery::on(function (Issue $issue) {
            $issue->setId(IssueTestBuilder::DEFAULT_PERSISTED_ID);

            return true;
        }))->andReturn(null);

        return $mock;
    }

    public static function getTopicTypeParentOnGetButNotFoundParentOnSave(): CreateProjectIssuePort
    {
        $mock = Mockery::mock(CreateProjectIssuePort::class);
        $mock->shouldReceive('get')->andReturn(null);
        $mock->shouldReceive('save')->with(Mockery::on(function (Issue $issue) {
            $issue->setId(IssueTestBuilder::DEFAULT_PERSISTED_ID);

            return true;
        }))->andReturn(null);

        return $mock;
    }

    public static function getNonTopicTypeParentOnGetAndDefaultIssuePersistedOnSave(): CreateProjectIssuePort
    {
        $mock = Mockery::mock(CreateProjectIssuePort::class);
        $mock->shouldReceive('get')->andReturn(IssueTestBuilder::getDefaultNew());
        $mock->shouldReceive('save')->with(Mockery::on(function (Issue $issue) {
            $issue->setId(IssueTestBuilder::DEFAULT_PERSISTED_ID);

            return true;
        }))->andReturn(null);

        return $mock;
    }

    public static function getExceptions(): CreateProjectIssuePort
    {
        $mock = Mockery::mock(CreateProjectIssuePort::class);
        $mock->shouldReceive('get')->andThrow(Exception::class);
        $mock->shouldReceive('save')->andThrow(Exception::class);

        return $mock;
    }
}