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
    use Specify;
    private const PROJECT_NAME = "name";

    public function testORMFailOnCreateReturnException(): void
    {
        $projectEntityRepository = ProjectEntityRepositoryMockBuilder::getRepositoryReturnExceptionOnPersist();
        $mapper = SymfonySerializerBuilder::get();
        $projectPersistenceAdapter = new ProjectPersistenceAdapter($projectEntityRepository, $mapper);
        $this->expectException(Exception::class);
        $projectPersistenceAdapter->save(ProjectTestBuilder::getDefaultNewProject());
    }

    public function testOnCreateSuccessReturnProjectDomainObject(): void
    {
        $projectEntityRepository = ProjectEntityRepositoryMockBuilder::getRepositoryReturnDefaultProjectOnPersist();
        $mapper = SymfonySerializerBuilder::get();
        $projectPersistenceAdapter = new ProjectPersistenceAdapter($projectEntityRepository, $mapper);
        $projectPersisted = $projectPersistenceAdapter->save(ProjectTestBuilder::getDefaultNewProject());
        $this->assertTrue($projectPersisted->getId() == ProjectEntityTestBuilder::DEFAULT_ID);
    }

    public function testORMFailOnGetReturnException(): void
    {
        $projectEntityRepository = ProjectEntityRepositoryMockBuilder::getRepositoryReturnExceptionOnFind();
        $mapper = SymfonySerializerBuilder::get();
        $projectPersistenceAdapter = new ProjectPersistenceAdapter($projectEntityRepository, $mapper);
        $this->expectException(Exception::class);
        $projectPersistenceAdapter->get(ProjectTestBuilder::PROJECT_ID);
    }

    public function testOnGetSuccessReturnProjectDomainObject(): void
    {
        $projectEntityRepository = ProjectEntityRepositoryMockBuilder::getRepositoryReturnDefaultProjectOnFind();
        $mapper = SymfonySerializerBuilder::get();
        $projectPersistenceAdapter = new ProjectPersistenceAdapter($projectEntityRepository, $mapper);
        $project = $projectPersistenceAdapter->get(ProjectTestBuilder::PROJECT_ID);
        $this->assertTrue($project->getId() == ProjectEntityTestBuilder::DEFAULT_ID);
    }

    public function testOnGetNotFoundReturnNull(): void
    {
        $projectEntityRepository = ProjectEntityRepositoryMockBuilder::getRepositoryReturnNullOnFind();
        $mapper = SymfonySerializerBuilder::get();
        $projectPersistenceAdapter = new ProjectPersistenceAdapter($projectEntityRepository, $mapper);
        $project = $projectPersistenceAdapter->get(ProjectTestBuilder::PROJECT_ID);
        $this->assertNull($project);
    }

}