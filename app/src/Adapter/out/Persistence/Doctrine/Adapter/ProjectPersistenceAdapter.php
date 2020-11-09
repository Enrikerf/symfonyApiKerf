<?php

namespace App\Adapter\out\Persistence\Doctrine\Adapter;

use App\Adapter\out\Persistence\Doctrine\Entity\ProjectEntity;
use App\Adapter\out\Persistence\Doctrine\Mapper\DoctrineMapperInterface;
use App\Adapter\out\Persistence\Doctrine\Repository\ProjectEntityRepository;
use App\Application\Port\out\Persistence\Database\GetProjectPort;
use App\Application\Port\out\Persistence\Database\GetProjectsByPort;
use App\Domain\Project\Project;
use Doctrine\ORM\ORMException;
use Exception;


class ProjectPersistenceAdapter implements GetProjectPort, GetProjectsByPort
{

    private const DEFAULT_OFFSET = 0;
    private const DEFAULT_LIMIT = 100;
    private ProjectEntityRepository $projectEntityRepository;
    private DoctrineMapperInterface $mapper;

    public function __construct(ProjectEntityRepository $projectEntityRepository, DoctrineMapperInterface $mapper)
    {
        $this->projectEntityRepository = $projectEntityRepository;
        $this->mapper = $mapper;
    }

    public function save(Project $project): Project
    {
        try {
            $projectEntity = $this->mapper->denormalize($project, ProjectEntity::class);
            $projectEntity = $this->projectEntityRepository->persistAndFlush($projectEntity);

            return $this->mapper->denormalize($projectEntity, Project::class);
        } catch (ORMException $e) {
            throw  new Exception($e->getMessage(), 500);
        }
    }

    /**
     * @param int $id
     *
     * @return Project|null
     * @throws Exception
     */
    public function get(int $id): ?Project
    {
        try {
            $projectEntity = $this->projectEntityRepository->find($id);

            return $this->mapper->denormalize($projectEntity, Project::class);
        } catch (ORMException $e) {
            throw  new Exception($e->getMessage(), 500);
        }
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return array|null
     * @throws Exception
     */
    public function getBy(array $criteria = [], array $orderBy = null, int $limit = null, int $offset = null): ?array
    {
        try {
            (!$limit) ? $limit = self::DEFAULT_LIMIT : null;
            (!$offset) ? $offset = self::DEFAULT_OFFSET : null;
            $projectEntityArray = $this->projectEntityRepository->findBy($criteria, $orderBy, $limit, $offset);

            return $this->mapper->denormalize($projectEntityArray, Project::class.'[]');
        } catch (ORMException $e) {
            throw  new Exception($e->getMessage(), 500);
        }
    }
}