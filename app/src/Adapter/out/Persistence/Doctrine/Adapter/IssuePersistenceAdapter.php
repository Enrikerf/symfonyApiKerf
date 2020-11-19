<?php

namespace App\Adapter\out\Persistence\Doctrine\Adapter;

use App\Adapter\out\Persistence\Doctrine\Entity\IssueEntity;
use App\Adapter\out\Persistence\Doctrine\Mapper\DoctrineMapperInterface;
use App\Adapter\out\Persistence\Doctrine\Repository\IssueEntityRepository;
use App\Application\Port\out\Persistence\Database\CreateProjectIssuePort;
use App\Application\Port\out\Persistence\Database\GetIssuePort;
use App\Domain\Issue\Issue;
use Exception;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\ValidatorBuilder;
use function PHPUnit\Framework\assertInstanceOf;


class IssuePersistenceAdapter implements GetIssuePort, CreateProjectIssuePort
{

    public const ORM_EXCEPTION = 500;
    private const DEFAULT_OFFSET = 0;
    private const DEFAULT_LIMIT = 100;
    private IssueEntityRepository   $issueEntityRepository;
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
                $childEntities = $this->issueEntityRepository->findBy(['parent'=>$issueEntity->getId()]);
                $child =  $this->mapper->denormalize($childEntities,Issue::class . '[]');
                $issue = $this->mapper->denormalize($issueEntity, Issue::class);
                $issue->setChilds($child);
                return $issue;
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
        $newIssueEntityData->getProjectId() !== null ? $issueEntityInDb->setProjectId($newIssueEntityData->getProjectId()) : null;
        $newIssueEntityData->getType() !== null ? $issueEntityInDb->setType($newIssueEntityData->getType()) : null;
        $newIssueEntityData->getTitle() !== null ? $issueEntityInDb->setTitle($newIssueEntityData->getTitle()) : null;
        $newIssueEntityData->getTime() !== null ? $issueEntityInDb->setTime($newIssueEntityData->getTime()) : null;
        $newIssueEntityData->getTotalTime() !== null ? $issueEntityInDb->setTotalTime($newIssueEntityData->getTotalTime()) : null;
        $newIssueEntityData->getParent() !== null ? $issueEntityInDb->setParent($newIssueEntityData->getParent()) : null;
    }
}