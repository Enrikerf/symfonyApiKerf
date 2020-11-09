<?php

namespace App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Repository;

use App\Adapter\out\Persistence\Doctrine\Repository\ProjectEntityRepository;
use App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Entity\ProjectEntityTestBuilder;
use Doctrine\ORM\ORMException;
use Mockery;


class ProjectEntityRepositoryMockBuilder
{

    public static function getRepositoryReturnExceptionOnPersist()
    {
        $projectEntityRepository = (Mockery::mock(ProjectEntityRepository::class));
        $projectEntityRepository->shouldReceive('persistAndFlush')
            ->andThrow(ORMException::class);

        return $projectEntityRepository;
    }

    public static function getRepositoryReturnDefaultProjectOnPersist()
    {
        $projectEntityRepository = Mockery::mock(ProjectEntityRepository::class);
        $projectEntityRepository->shouldReceive('persistAndFlush')
            ->andReturn(ProjectEntityTestBuilder::getDefaultProject());

        return $projectEntityRepository;
    }

    public static function getRepositoryReturnExceptionOnFind()
    {
        $projectEntityRepository = (Mockery::mock(ProjectEntityRepository::class));
        $projectEntityRepository->shouldReceive('find')
            ->andThrow(ORMException::class);

        return $projectEntityRepository;
    }

    public static function getRepositoryReturnDefaultProjectOnFind()
    {
        $projectEntityRepository = Mockery::mock(ProjectEntityRepository::class);
        $projectEntityRepository->shouldReceive('find')
            ->andReturn(ProjectEntityTestBuilder::getDefaultProject());

        return $projectEntityRepository;
    }

    public static function getRepositoryReturnNullOnFind()
    {
        $projectEntityRepository = Mockery::mock(ProjectEntityRepository::class);
        $projectEntityRepository->shouldReceive('find')
            ->andReturn(null);

        return $projectEntityRepository;
    }
}