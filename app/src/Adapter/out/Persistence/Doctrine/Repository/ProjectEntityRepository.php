<?php

namespace App\Adapter\out\Persistence\Doctrine\Repository;

use App\Adapter\out\Persistence\Doctrine\Entity\ProjectEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;


class ProjectEntityRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectEntity::class);
    }

    /**
     * @param ProjectEntity $project
     *
     * @return ProjectEntity
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function persistAndFlush(ProjectEntity $project): ProjectEntity
    {
        $this->getEntityManager()->persist($project);
        $this->getEntityManager()->flush();

        return $project;
    }

}