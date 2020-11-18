<?php

namespace App\Adapter\out\Persistence\Doctrine\Repository;

use App\Adapter\out\Persistence\Doctrine\Entity\IssueEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;


class IssueEntityRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IssueEntity::class);
    }

    /**
     * @param IssueEntity $project
     *
     * @return IssueEntity
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function persistAndFlush(IssueEntity $project): IssueEntity
    {
        $this->getEntityManager()->persist($project);
        $this->getEntityManager()->flush();

        return $project;
    }

}