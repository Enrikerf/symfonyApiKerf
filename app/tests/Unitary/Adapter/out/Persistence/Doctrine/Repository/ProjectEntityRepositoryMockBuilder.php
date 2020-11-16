<?php

namespace App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Repository;

use App\Adapter\out\Persistence\Doctrine\Repository\ProjectEntityRepository;
use App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Entity\ProjectEntityTestBuilder;
use Doctrine\ORM\ORMException;
use Mockery;


class ProjectEntityRepositoryMockBuilder
{

    public static function getReturnExceptionOnPersist()
    {
        $projectEntityRepository = (Mockery::mock(ProjectEntityRepository::class));
        $projectEntityRepository->shouldReceive('persistAndFlush')
            ->andThrow(ORMException::class);

        return $projectEntityRepository;
    }

    public static function getReturnDefaultProjectOnPersist()
    {
        $projectEntityRepository = Mockery::mock(ProjectEntityRepository::class);
        $projectEntityRepository->shouldReceive('persistAndFlush')
            ->andReturn(ProjectEntityTestBuilder::getDefaultProject());

        return $projectEntityRepository;
    }

    public static function getReturnDefaultProjectOnUpdate()
    {
        $projectEntityRepository = Mockery::mock(ProjectEntityRepository::class);
        $projectEntityRepository->allows([
            'persistAndFlush' =>ProjectEntityTestBuilder::getDefaultProject(),
            'find' =>ProjectEntityTestBuilder::getDefaultProject()
        ])
         ;

        return $projectEntityRepository;
    }

    public static function getReturnExceptionOnUpdate()
    {
        $projectEntityRepository = (Mockery::mock(ProjectEntityRepository::class));
        $projectEntityRepository->shouldReceive(['persistAndFlush','find'])
            ->andThrow(ORMException::class);

        return $projectEntityRepository;
    }

    public static function getReturnExceptionOnFind()
    {
        $projectEntityRepository = (Mockery::mock(ProjectEntityRepository::class));
        $projectEntityRepository->shouldReceive('find')
            ->andThrow(ORMException::class);

        return $projectEntityRepository;
    }

    public static function getReturnDefaultProjectOnFind()
    {
        $projectEntityRepository = Mockery::mock(ProjectEntityRepository::class);
        $projectEntityRepository->shouldReceive('find')
            ->andReturn(ProjectEntityTestBuilder::getDefaultProject());

        return $projectEntityRepository;
    }

    public static function getReturnNullOnFind()
    {
        $projectEntityRepository = Mockery::mock(ProjectEntityRepository::class);
        $projectEntityRepository->shouldReceive('find')
            ->andReturn(null);

        return $projectEntityRepository;
    }

    public static function getReturnExceptionOnFindBy()
    {
        $projectEntityRepository = (Mockery::mock(ProjectEntityRepository::class));
        $projectEntityRepository->shouldReceive('findBy')
            ->andThrow(ORMException::class);

        return $projectEntityRepository;
    }

    public static function getReturnArrayOfProjectOnFindBy()
    {
        $projectEntityRepository = (Mockery::mock(ProjectEntityRepository::class));
        $projectEntityRepository->shouldReceive('findBy')
            ->andReturn([ProjectEntityTestBuilder::getDefaultProject()]);

        return $projectEntityRepository;
    }

}