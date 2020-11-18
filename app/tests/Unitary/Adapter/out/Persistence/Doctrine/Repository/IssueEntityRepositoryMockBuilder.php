<?php

namespace App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Repository;

use App\Adapter\out\Persistence\Doctrine\Entity\IssueEntity;
use App\Adapter\out\Persistence\Doctrine\Repository\IssueEntityRepository;
use App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Entity\IssueEntityTestBuilder;
use Doctrine\ORM\ORMException;
use Mockery;


class IssueEntityRepositoryMockBuilder
{

    public static function getReturnExceptionOnPersist()
    {
        $projectEntityRepository = (Mockery::mock(IssueEntityRepository::class));
        $projectEntityRepository->shouldReceive('persistAndFlush')
            ->andThrow(ORMException::class);

        return $projectEntityRepository;
    }

    public static function getReturnDefaultProjectOnPersist()
    {
        $projectEntityRepository = Mockery::mock(IssueEntityRepository::class);
        $projectEntityRepository->shouldReceive('persistAndFlush')
            ->andReturn(IssueEntityTestBuilder::getDefaultNew());

        return $projectEntityRepository;
    }

    public static function getReturnDefaultProjectOnUpdate()
    {
        $projectEntityRepository = Mockery::mock(IssueEntityRepository::class);
        $projectEntityRepository->allows([
            'find' => IssueEntityTestBuilder::getDefaultNew(),
        ]);
        $projectEntityRepository->shouldReceive('persistAndFlush')->andReturnUsing(function (
            IssueEntity $projectEntity
        ) {
            return $projectEntity;
        });

        return $projectEntityRepository;
    }

    public static function getReturnExceptionOnUpdate()
    {
        $projectEntityRepository = (Mockery::mock(IssueEntityRepository::class));
        $projectEntityRepository->shouldReceive(['persistAndFlush', 'find'])
            ->andThrow(ORMException::class);

        return $projectEntityRepository;
    }

    public static function getReturnExceptionOnFind()
    {
        $projectEntityRepository = (Mockery::mock(IssueEntityRepository::class));
        $projectEntityRepository->shouldReceive('find')
            ->andThrow(ORMException::class);

        return $projectEntityRepository;
    }

    public static function getReturnDefaultProjectOnFind()
    {
        $projectEntityRepository = Mockery::mock(IssueEntityRepository::class);
        $projectEntityRepository->shouldReceive('find')
            ->andReturn(IssueEntityTestBuilder::getDefaultNew());

        return $projectEntityRepository;
    }

    public static function getReturnNullOnFind()
    {
        $projectEntityRepository = Mockery::mock(IssueEntityRepository::class);
        $projectEntityRepository->shouldReceive('find')
            ->andReturn(null);

        return $projectEntityRepository;
    }

    public static function getReturnExceptionOnFindBy()
    {
        $projectEntityRepository = (Mockery::mock(IssueEntityRepository::class));
        $projectEntityRepository->shouldReceive('findBy')
            ->andThrow(ORMException::class);

        return $projectEntityRepository;
    }

    public static function getReturnArrayOfProjectOnFindBy()
    {
        $projectEntityRepository = (Mockery::mock(IssueEntityRepository::class));
        $projectEntityRepository->shouldReceive('findBy')
            ->andReturn([IssueEntityTestBuilder::getDefaultNew()]);

        return $projectEntityRepository;
    }
}