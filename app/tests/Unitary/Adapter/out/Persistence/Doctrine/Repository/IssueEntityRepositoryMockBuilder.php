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
        $issueEntityRepository = (Mockery::mock(IssueEntityRepository::class));
        $issueEntityRepository->shouldReceive('persistAndFlush')
            ->andThrow(ORMException::class);

        return $issueEntityRepository;
    }

    public static function getReturnDefaultProjectOnPersist()
    {
        $issueEntityRepository = Mockery::mock(IssueEntityRepository::class);
        $issueEntityRepository->shouldReceive('persistAndFlush')->andReturnUsing(function (
            IssueEntity $issueEntity
        ) {
            $issueEntity->setId(IssueEntityTestBuilder::DEFAULT_ID);
            return $issueEntity;
        });

        return $issueEntityRepository;
    }

    public static function getReturnDefaultProjectOnUpdate()
    {
        $issueEntityRepository = Mockery::mock(IssueEntityRepository::class);
        $issueEntityRepository->allows([
            'find' => IssueEntityTestBuilder::getDefaultNew(),
        ]);
        $issueEntityRepository->shouldReceive('persistAndFlush')->andReturnUsing(function (
            IssueEntity $issueEntity
        ) {
            return $issueEntity;
        });

        return $issueEntityRepository;
    }

    public static function getReturnExceptionOnUpdate()
    {
        $issueEntityRepository = (Mockery::mock(IssueEntityRepository::class));
        $issueEntityRepository->shouldReceive(['persistAndFlush', 'find'])
            ->andThrow(ORMException::class);

        return $issueEntityRepository;
    }

    public static function getReturnExceptionOnFind()
    {
        $issueEntityRepository = (Mockery::mock(IssueEntityRepository::class));
        $issueEntityRepository->shouldReceive('find')
            ->andThrow(ORMException::class);

        return $issueEntityRepository;
    }

    public static function getReturnDefaultProjectOnFind()
    {
        $issueEntityRepository = Mockery::mock(IssueEntityRepository::class);
        $issueEntityRepository->shouldReceive('find')
            ->andReturn(IssueEntityTestBuilder::getDefaultNew());

        return $issueEntityRepository;
    }

    public static function getReturnNullOnFind()
    {
        $issueEntityRepository = Mockery::mock(IssueEntityRepository::class);
        $issueEntityRepository->shouldReceive('find')
            ->andReturn(null);

        return $issueEntityRepository;
    }

    public static function getReturnExceptionOnFindBy()
    {
        $issueEntityRepository = (Mockery::mock(IssueEntityRepository::class));
        $issueEntityRepository->shouldReceive('findBy')
            ->andThrow(ORMException::class);

        return $issueEntityRepository;
    }

    public static function getReturnArrayOfProjectOnFindBy()
    {
        $issueEntityRepository = (Mockery::mock(IssueEntityRepository::class));
        $issueEntityRepository->shouldReceive('findBy')
            ->andReturn([IssueEntityTestBuilder::getDefaultNew()]);

        return $issueEntityRepository;
    }
}