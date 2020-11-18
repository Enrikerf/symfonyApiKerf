<?php

namespace App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Adapter;

use App\Adapter\out\Persistence\Doctrine\Adapter\IssuePersistenceAdapter;
use App\Adapter\out\Persistence\Doctrine\Adapter\ProjectPersistenceAdapter;
use App\Domain\Project\Project;
use App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Entity\ProjectEntityTestBuilder;
use App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Repository\IssueEntityRepositoryMockBuilder;
use App\Tests\Unitary\Adapter\out\Serializer\SymfonySerializerMockBuilder;
use App\Tests\Unitary\Adapter\out\Serializer\SymfonySerializerTestBuilder;
use App\Tests\Unitary\Domain\Issue\IssueTestBuilder;
use App\Tests\Unitary\Domain\Project\ProjectTestBuilder;
use Exception;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;


class IssuePersistenceAdapterTest extends TestCase
{

    use MockeryPHPUnitIntegration;

    private function constructPersistenceAdapter($issueEntityRepository, $mapper = null)
    {
        $mapper ? null : $mapper = SymfonySerializerTestBuilder::get();

        return new IssuePersistenceAdapter($issueEntityRepository, $mapper);
    }

    public function testSaveThrowExceptionWithORMExceptionCodeOnORMException(): void
    {
        $this->markTestSkipped("implementing feature");
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnExceptionOnPersist();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository);
        $this->expectException(Exception::class);
        $this->expectExceptionCode(ProjectPersistenceAdapter::ORM_EXCEPTION);
        $issue = IssueTestBuilder::getDefaultNew();
        $projectPersistenceAdapter->save($issue);
    }

    public function testSaveThrowExceptionWithORMExceptionCodeOnSerializerException(): void
    {
        $this->markTestSkipped();
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnDefaultProjectOnPersist();
        $mapperMock = SymfonySerializerMockBuilder::getExceptionOnDenormalize();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository, $mapperMock);
        $this->expectException(Exception::class);
        $this->expectExceptionCode(ProjectPersistenceAdapter::ORM_EXCEPTION);
        $issue = IssueTestBuilder::getDefaultNew();
        $projectPersistenceAdapter->save($issue);
    }

    public function testSaveReturnDomainObjectOnSuccess(): void
    {
        $this->markTestSkipped();
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnDefaultProjectOnPersist();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository);
        $issue = IssueTestBuilder::getDefaultNew();
        $projectPersistenceAdapter->save($issue);
        $this->assertTrue($issue instanceof Project);
        $this->assertTrue($issue->getId() == ProjectEntityTestBuilder::DEFAULT_ID);
    }

    public function testGetByIdThrowExceptionOnOrmException(): void
    {
        $this->markTestSkipped();
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnDefaultProjectOnFind();
        $mapperMock = SymfonySerializerMockBuilder::getExceptionOnDenormalize();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository, $mapperMock);
        $this->expectException(Exception::class);
        $this->expectExceptionCode(ProjectPersistenceAdapter::ORM_EXCEPTION);
        $projectPersistenceAdapter->get(ProjectTestBuilder::DEFAULT_PROJECT_ID);
    }

    public function testGetByIdThrowExceptionOnSerializerException(): void
    {
        $this->markTestSkipped("implementing feature");
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnExceptionOnFind();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository);
        $this->expectException(Exception::class);
        $this->expectExceptionCode(ProjectPersistenceAdapter::ORM_EXCEPTION);
        $projectPersistenceAdapter->get(ProjectTestBuilder::DEFAULT_PROJECT_ID);
    }

    public function testGetByIdReturnProjectDomainObjectOnSuccess(): void
    {
        $this->markTestSkipped("implementing feature");
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnDefaultProjectOnFind();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository);
        $project = $projectPersistenceAdapter->get(ProjectTestBuilder::DEFAULT_PROJECT_ID);
        $this->assertTrue($project instanceof Project);
        $this->assertTrue($project->getId() == ProjectEntityTestBuilder::DEFAULT_ID);
    }

    public function testGetByIdReturnNullOnNotFound(): void
    {
        $this->markTestSkipped("implementing feature");
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnNullOnFind();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository);
        $project = $projectPersistenceAdapter->get(ProjectTestBuilder::DEFAULT_PROJECT_ID);
        $this->assertNull($project);
    }

    public function testGetByCriteriaThrowExceptionWithORMExceptionCodeOnORMException(): void
    {
        $this->markTestSkipped("implementing feature");
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnExceptionOnFindBy();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository);
        $this->expectException(Exception::class);
        $this->expectExceptionCode(ProjectPersistenceAdapter::ORM_EXCEPTION);
        $projectPersistenceAdapter->getBy([]);
    }

    public function testGetByCriteriaThrowExceptionWithORMExceptionCodeOnSerializerException(): void
    {
        $this->markTestSkipped("implementing feature");
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnArrayOfProjectOnFindBy();
        $mapperMock = SymfonySerializerMockBuilder::getExceptionOnDenormalize();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository, $mapperMock);
        $this->expectException(Exception::class);
        $this->expectExceptionCode(ProjectPersistenceAdapter::ORM_EXCEPTION);
        $projectPersistenceAdapter->getBy([]);
    }

    public function testGetByCriteriaReturnArrayOfProjectDomainObjectOnSuccess(): void
    {
        $this->markTestSkipped("implementing feature");
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnArrayOfProjectOnFindBy();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository);
        $projects = $projectPersistenceAdapter->getBy([]);
        $this->assertIsArray($projects);
        $this->assertTrue($projects[0] instanceof Project);
    }

    public function testUpdateThrowExceptionWithOrmExceptionCodeOnORMException()
    {
        $this->markTestSkipped("implementing feature");
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnExceptionOnUpdate();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository);
        $this->expectException(Exception::class);
        $this->expectExceptionCode(ProjectPersistenceAdapter::ORM_EXCEPTION);
        $project = ProjectTestBuilder::getDefaultNewProject();
        $projectPersistenceAdapter->update($project);
    }

    public function testUpdateThrowExceptionWithORMExceptionCodeOnSerializerException(): void
    {
        $this->markTestSkipped("implementing feature");
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnDefaultProjectOnUpdate();
        $mapperMock = SymfonySerializerMockBuilder::getExceptionOnDenormalize();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository, $mapperMock);
        $this->expectException(Exception::class);
        $this->expectExceptionCode(ProjectPersistenceAdapter::ORM_EXCEPTION);
        $project = ProjectTestBuilder::getDefaultNewProject();
        $projectPersistenceAdapter->update($project);
    }

    public function testUpdateReturnProjectDomainObjectOnSuccessWithModifiedVars(): void
    {
        $this->markTestSkipped("implementing feature");
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnDefaultProjectOnUpdate();
        $projectPersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository);
        $project = ProjectTestBuilder::getDefaultPersistedProject();
        $project->setName(ProjectTestBuilder::NOT_DEFAULT_NAME);
        $project->setIssueCount(ProjectTestBuilder::NOT_DEFAULT_ISSUE_COUNT);
        $projectPersistenceAdapter->update($project);
        $this->assertTrue($project->getId() == ProjectEntityTestBuilder::DEFAULT_ID);
        $this->assertEquals($project->getName(), ProjectTestBuilder::NOT_DEFAULT_NAME);
        $this->assertEquals($project->getIssueCount(), ProjectTestBuilder::NOT_DEFAULT_ISSUE_COUNT);
    }
}