<?php

namespace App\Adapter\out\Persistence\Doctrine\Adapter;

use App\Adapter\out\Persistence\Doctrine\Entity\IssueEntity;
use App\Adapter\out\Persistence\Doctrine\Mapper\DoctrineMapperInterface;
use App\Adapter\out\Persistence\Doctrine\Repository\IssueEntityRepository;
use Exception;
use OpenAPI\Server\Model\Issue;


class IssuePersistenceAdapter
{

    public const ORM_EXCEPTION = 500;
    private const DEFAULT_OFFSET = 0;
    private const DEFAULT_LIMIT = 100;
    private IssueEntityRepository $issueEntityRepository;
    private DoctrineMapperInterface $mapper;

    public function __construct(IssueEntityRepository $issueEntityRepository, DoctrineMapperInterface $mapper)
    {
        $this->issueEntityRepository = $issueEntityRepository;
        $this->mapper = $mapper;
    }

    /**
     * @param Issue $issue
     *
     * @return void
     * @throws Exception
     */
    public function save(Issue &$issue): void
    {
        try {
            $issueEntity = $this->mapper->denormalize($issue, IssueEntity::class);
            $issueEntity = $this->issueEntityRepository->persistAndFlush($issueEntity);
            $issue = $this->mapper->denormalize($issueEntity, Issue::class);
        } catch (Exception $e) {
            throw  new Exception($e->getMessage(), self::ORM_EXCEPTION);
        }
    }

    /**
     * @param int $id
     *
     * @return Issue|null
     * @throws Exception
     */
    public function get(int $id): ?Issue
    {
        try {
            if ($issueEntity = $this->issueEntityRepository->find($id)) {
                return $this->mapper->denormalize($issueEntity, Issue::class);
            } else {
                return null;
            }
        } catch (Exception $e) {
            throw  new Exception($e->getMessage(), self::ORM_EXCEPTION);
        }
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return array
     * @throws Exception
     */
    public function getBy(array $criteria = [], array $orderBy = null, int $limit = null, int $offset = null): array
    {
        try {
            (!$limit) ? $limit = self::DEFAULT_LIMIT : null;
            (!$offset) ? $offset = self::DEFAULT_OFFSET : null;
            $issueEntityArray = $this->issueEntityRepository->findBy($criteria, $orderBy, $limit, $offset);

            return $this->mapper->denormalize($issueEntityArray, Issue::class.'[]');
        } catch (Exception $e) {
            throw  new Exception($e->getMessage(), self::ORM_EXCEPTION);
        }
    }

    /**
     * @param Issue $issue
     *
     * @throws Exception
     */
    public function update(Issue &$issue): void
    {
        try {
            $issueEntity = $this->mapper->denormalize($issue, IssueEntity::class);
            /** @var IssueEntity $issueEntityInDb */
            $issueEntityInDb = $this->issueEntityRepository->find($issueEntity->getId());
            $this->updateContent($issueEntityInDb, $issueEntity);
            $this->issueEntityRepository->persistAndFlush($issueEntityInDb);
            $issue = $this->mapper->denormalize($issueEntityInDb, Issue::class);
        } catch (Exception $e) {
            throw  new Exception($e->getMessage(), self::ORM_EXCEPTION);
        }
    }

    private function updateContent(IssueEntity &$issueEntityInDb, IssueEntity $newIssueEntityData)
    {
        $newIssueEntityData->getName() !== null ? $issueEntityInDb->setName($newIssueEntityData->getName()) : null;
        $newIssueEntityData->getIssueCount() !== null ? $issueEntityInDb->setIssueCount($newIssueEntityData->getIssueCount()) : null;
    }
}