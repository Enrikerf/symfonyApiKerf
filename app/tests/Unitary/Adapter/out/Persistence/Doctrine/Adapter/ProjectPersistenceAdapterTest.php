<?php

namespace App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Adapter;

use App\Adapter\out\Persistence\Doctrine\Adapter\ProjectPersistenceAdapter;
use App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Entity\ProjectEntityTestBuilder;
use App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Repository\ProjectEntityRepositoryMockBuilder;
use App\Tests\Unitary\Adapter\out\Serializer\SymfonySerializerBuilder;
use App\Tests\Unitary\Domain\Project\ProjectTestBuilder;
use Codeception\Specify;
use Exception;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;


class ProjectPersistenceAdapterTest extends TestCase
{

    use MockeryPHPUnitIntegration;

    private function constructPersistenceAdapter($projectEntityRepository)
    {
        $mapper = SymfonySerializerBuilder::get();

        return new ProjectPersistenceAdapter($projectEntityRepository, $mapper);
    }

    public function testORMFailOnCreateReturnException(): void
    {
        $projectEntityRepository = ProjectEntityRepositoryMockBuilder::getReturnExceptionOnPersist();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($projectEntityRepository);
        $this->expectException(Exception::class);
        $projectPersistenceAdapter->save(ProjectTestBuilder::getDefaultNewProject());
    }

    public function testOnCreateSuccessReturnProjectDomainObject(): void
    {
        $projectEntityRepository = ProjectEntityRepositoryMockBuilder::getReturnDefaultProjectOnPersist();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($projectEntityRepository);
        $projectPersisted = $projectPersistenceAdapter->save(ProjectTestBuilder::getDefaultNewProject());
        $this->assertTrue($projectPersisted->getId() == ProjectEntityTestBuilder::DEFAULT_ID);
    }

    public function testORMFailOnGetByIdReturnException(): void
    {
        $projectEntityRepository = ProjectEntityRepositoryMockBuilder::getReturnExceptionOnFind();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($projectEntityRepository);
        $this->expectException(Exception::class);
        $projectPersistenceAdapter->get(ProjectTestBuilder::PROJECT_ID);
    }

    public function testOnGetByIdSuccessReturnProjectDomainObject(): void
    {
        $projectEntityRepository = ProjectEntityRepositoryMockBuilder::getReturnDefaultProjectOnFind();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($projectEntityRepository);
        $project = $projectPersistenceAdapter->get(ProjectTestBuilder::PROJECT_ID);
        $this->assertTrue($project->getId() == ProjectEntityTestBuilder::DEFAULT_ID);
    }

    public function testOnGetByIdNotFoundReturnNull(): void
    {
        $projectEntityRepository = ProjectEntityRepositoryMockBuilder::getReturnNullOnFind();
        $mapper = SymfonySerializerBuilder::get();
        $projectPersistenceAdapter = new ProjectPersistenceAdapter($projectEntityRepository, $mapper);
        $project = $projectPersistenceAdapter->get(ProjectTestBuilder::PROJECT_ID);
        $this->assertNull($project);
    }

    public function testORMFailOnGetByCriteriaReturnException(): void
    {
        $projectEntityRepository = ProjectEntityRepositoryMockBuilder::getReturnExceptionOnGetBy();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($projectEntityRepository);
        $this->expectException(Exception::class);
        $projectPersistenceAdapter->getBy([]);
    }

    public function testOnGetByCriteriaSuccessReturnArrayOfProjectDomainObject(): void
    {
        $projectEntityRepository = ProjectEntityRepositoryMockBuilder::getReturnArrayOfProjectOnGetBy();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($projectEntityRepository);
        $projects = $projectPersistenceAdapter->getBy([]);
        $this->assertIsArray($projects);
    }
}