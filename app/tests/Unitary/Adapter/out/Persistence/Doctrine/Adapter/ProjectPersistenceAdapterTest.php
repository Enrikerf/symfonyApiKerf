<?php

namespace App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Adapter;

use App\Adapter\out\Persistence\Doctrine\Adapter\ProjectPersistenceAdapter;
use App\Domain\Project\Project;
use App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Entity\ProjectEntityTestBuilder;
use App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Repository\ProjectEntityRepositoryMockBuilder;
use App\Tests\Unitary\Adapter\out\Serializer\SymfonySerializerMockBuilder;
use App\Tests\Unitary\Adapter\out\Serializer\SymfonySerializerTestBuilder;
use App\Tests\Unitary\Domain\Project\ProjectTestBuilder;
use Exception;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;


class ProjectPersistenceAdapterTest extends TestCase
{

    use MockeryPHPUnitIntegration;

    private function constructPersistenceAdapter($projectEntityRepository, $mapper = null)
    {
        $mapper ? null : $mapper = SymfonySerializerTestBuilder::get();

        return new ProjectPersistenceAdapter($projectEntityRepository, $mapper);
    }

    public function testSaveThrowExceptionWithORMExceptionCodeOnORMException(): void
    {
        $projectEntityRepository = ProjectEntityRepositoryMockBuilder::getReturnExceptionOnPersist();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($projectEntityRepository);
        $this->expectException(Exception::class);
        $this->expectExceptionCode(ProjectPersistenceAdapter::ORM_EXCEPTION);
        $project = ProjectTestBuilder::getDefaultNewProject();
        $projectPersistenceAdapter->save($project);
    }

    public function testSaveThrowExceptionWithORMExceptionCodeOnSerializerException(): void
    {
        $projectEntityRepository = ProjectEntityRepositoryMockBuilder::getReturnDefaultProjectOnPersist();
        $mapperMock = SymfonySerializerMockBuilder::getExceptionOnDenormalize();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($projectEntityRepository, $mapperMock);
        $this->expectException(Exception::class);
        $this->expectExceptionCode(ProjectPersistenceAdapter::ORM_EXCEPTION);
        $project = ProjectTestBuilder::getDefaultNewProject();
        $projectPersistenceAdapter->save($project);
    }

    public function testSaveReturnProjectDomainObjectOnSuccess(): void
    {
        $projectEntityRepository = ProjectEntityRepositoryMockBuilder::getReturnDefaultProjectOnPersist();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($projectEntityRepository);
        $project = ProjectTestBuilder::getDefaultNewProject();
        $projectPersistenceAdapter->save($project);
        $this->assertTrue($project instanceof Project);
        $this->assertTrue($project->getId() == ProjectEntityTestBuilder::DEFAULT_ID);
    }

    public function testGetByIdThrowExceptionOnOrmException(): void
    {
        $projectEntityRepository = ProjectEntityRepositoryMockBuilder::getReturnDefaultProjectOnFind();
        $mapperMock = SymfonySerializerMockBuilder::getExceptionOnDenormalize();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($projectEntityRepository, $mapperMock);
        $this->expectException(Exception::class);
        $this->expectExceptionCode(ProjectPersistenceAdapter::ORM_EXCEPTION);
        $projectPersistenceAdapter->get(ProjectTestBuilder::DEFAULT_PROJECT_ID);
    }

    public function testGetByIdThrowExceptionOnSerializerException(): void
    {
        $projectEntityRepository = ProjectEntityRepositoryMockBuilder::getReturnExceptionOnFind();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($projectEntityRepository);
        $this->expectException(Exception::class);
        $this->expectExceptionCode(ProjectPersistenceAdapter::ORM_EXCEPTION);
        $projectPersistenceAdapter->get(ProjectTestBuilder::DEFAULT_PROJECT_ID);
    }

    public function testGetByIdReturnProjectDomainObjectOnSuccess(): void
    {
        $projectEntityRepository = ProjectEntityRepositoryMockBuilder::getReturnDefaultProjectOnFind();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($projectEntityRepository);
        $project = $projectPersistenceAdapter->get(ProjectTestBuilder::DEFAULT_PROJECT_ID);
        $this->assertTrue($project instanceof Project);
        $this->assertTrue($project->getId() == ProjectEntityTestBuilder::DEFAULT_ID);
    }

    public function testGetByIdReturnNullOnNotFound(): void
    {
        $projectEntityRepository = ProjectEntityRepositoryMockBuilder::getReturnNullOnFind();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($projectEntityRepository);
        $project = $projectPersistenceAdapter->get(ProjectTestBuilder::DEFAULT_PROJECT_ID);
        $this->assertNull($project);
    }

    public function testGetByCriteriaThrowExceptionWithORMExceptionCodeOnORMException(): void
    {
        $projectEntityRepository = ProjectEntityRepositoryMockBuilder::getReturnExceptionOnFindBy();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($projectEntityRepository);
        $this->expectException(Exception::class);
        $this->expectExceptionCode(ProjectPersistenceAdapter::ORM_EXCEPTION);
        $projectPersistenceAdapter->getBy([]);
    }

    public function testGetByCriteriaThrowExceptionWithORMExceptionCodeOnSerializerException(): void
    {
        $projectEntityRepository = ProjectEntityRepositoryMockBuilder::getReturnArrayOfProjectOnFindBy();
        $mapperMock = SymfonySerializerMockBuilder::getExceptionOnDenormalize();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($projectEntityRepository,$mapperMock);
        $this->expectException(Exception::class);
        $this->expectExceptionCode(ProjectPersistenceAdapter::ORM_EXCEPTION);
        $projectPersistenceAdapter->getBy([]);
    }

    public function testGetByCriteriaReturnArrayOfProjectDomainObjectOnSuccess(): void
    {
        $projectEntityRepository = ProjectEntityRepositoryMockBuilder::getReturnArrayOfProjectOnFindBy();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($projectEntityRepository);
        $projects = $projectPersistenceAdapter->getBy([]);
        $this->assertIsArray($projects);
        $this->assertTrue($projects[0] instanceof Project);
    }
}