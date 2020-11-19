<?php

namespace App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Adapter;

use App\Adapter\out\Persistence\Doctrine\Adapter\IssuePersistenceAdapter;
use App\Domain\Issue\Issue;
use App\Domain\Project\Project;
use App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Entity\IssueEntityTestBuilder;
use App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Repository\IssueEntityRepositoryMockBuilder;
use App\Tests\Unitary\Adapter\out\Serializer\SymfonySerializerMockBuilder;
use App\Tests\Unitary\Adapter\out\Serializer\SymfonySerializerTestBuilder;
use App\Tests\Unitary\Domain\Issue\IssueTestBuilder;
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
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnExceptionOnPersist();
        $issuePersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository);
        $this->expectException(Exception::class);
        $this->expectExceptionCode(IssuePersistenceAdapter::ORM_EXCEPTION);
        $issue = IssueTestBuilder::getDefaultNew();
        $issuePersistenceAdapter->save($issue);
    }

    public function testSaveThrowExceptionWithORMExceptionCodeOnSerializerException(): void
    {
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnDefaultProjectOnPersist();
        $mapperMock = SymfonySerializerMockBuilder::getExceptionOnDenormalize();
        $issuePersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository, $mapperMock);
        $this->expectException(Exception::class);
        $this->expectExceptionCode(IssuePersistenceAdapter::ORM_EXCEPTION);
        $issue = IssueTestBuilder::getDefaultNew();
        $issuePersistenceAdapter->save($issue);
    }

    public function testSaveReturnDomainObjectOnSuccess(): void
    {
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnDefaultProjectOnPersist();
        $issuePersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository);
        $issue = IssueTestBuilder::getDefaultTypeTopic();
        $issuePersistenceAdapter->save($issue);
        $this->assertTrue($issue instanceof Issue);
        $this->assertTrue($issue->getId() == IssueEntityTestBuilder::DEFAULT_ID);
    }

    public function testGetByIdThrowExceptionOnOrmException(): void
    {
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnDefaultProjectOnFind();
        $mapperMock = SymfonySerializerMockBuilder::getExceptionOnDenormalize();
        $issuePersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository, $mapperMock);
        $this->expectException(Exception::class);
        $this->expectExceptionCode(IssuePersistenceAdapter::ORM_EXCEPTION);
        $issuePersistenceAdapter->get(IssueTestBuilder::DEFAULT_PERSISTED_ID);
    }

    public function testGetByIdThrowExceptionOnSerializerException(): void
    {
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnExceptionOnFind();
        $issuePersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository);
        $this->expectException(Exception::class);
        $this->expectExceptionCode(IssuePersistenceAdapter::ORM_EXCEPTION);
        $issuePersistenceAdapter->get(IssueTestBuilder::DEFAULT_PROJECT_ID);
    }

    public function testGetByIdReturnProjectDomainObjectOnSuccess(): void
    {
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnDefaultProjectOnFind();
        $issuePersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository);
        $issue = $issuePersistenceAdapter->get(IssueTestBuilder::DEFAULT_PROJECT_ID);
        $this->assertTrue($issue instanceof Issue);
        $this->assertTrue($issue->getId() == IssueEntityTestBuilder::DEFAULT_ID);
    }

    public function testGetByIdReturnNullOnNotFound(): void
    {
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnNullOnFind();
        $issuePersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository);
        $issue = $issuePersistenceAdapter->get(IssueTestBuilder::DEFAULT_PROJECT_ID);
        $this->assertNull($issue);
    }

    public function testGetByCriteriaThrowExceptionWithORMExceptionCodeOnORMException(): void
    {
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnExceptionOnFindBy();
        $issuePersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository);
        $this->expectException(Exception::class);
        $this->expectExceptionCode(IssuePersistenceAdapter::ORM_EXCEPTION);
        $issuePersistenceAdapter->getBy([]);
    }

    public function testGetByCriteriaThrowExceptionWithORMExceptionCodeOnSerializerException(): void
    {
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnArrayOfProjectOnFindBy();
        $mapperMock = SymfonySerializerMockBuilder::getExceptionOnDenormalize();
        $issuePersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository, $mapperMock);
        $this->expectException(Exception::class);
        $this->expectExceptionCode(IssuePersistenceAdapter::ORM_EXCEPTION);
        $issuePersistenceAdapter->getBy([]);
    }

    public function testGetByCriteriaReturnArrayOfProjectDomainObjectOnSuccess(): void
    {
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnArrayOfProjectOnFindBy();
        $issuePersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository);
        $issues = $issuePersistenceAdapter->getBy([]);
        $this->assertIsArray($issues);
        $this->assertTrue($issues[0] instanceof Issue);
    }

    public function testUpdateThrowExceptionWithOrmExceptionCodeOnORMException()
    {
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnExceptionOnUpdate();
        $issuePersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository);
        $this->expectException(Exception::class);
        $this->expectExceptionCode(IssuePersistenceAdapter::ORM_EXCEPTION);
        $issue = IssueTestBuilder::getDefaultPersisted();
        $issuePersistenceAdapter->update($issue);
    }

    public function testUpdateThrowExceptionWithORMExceptionCodeOnSerializerException(): void
    {
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnDefaultProjectOnUpdate();
        $mapperMock = SymfonySerializerMockBuilder::getExceptionOnDenormalize();
        $issuePersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository, $mapperMock);
        $this->expectException(Exception::class);
        $this->expectExceptionCode(IssuePersistenceAdapter::ORM_EXCEPTION);
        $issue = IssueTestBuilder::getDefaultPersisted();
        $issuePersistenceAdapter->update($issue);
    }

    public function testUpdateReturnProjectDomainObjectOnSuccessWithModifiedVars(): void
    {
        $issueEntityRepository = IssueEntityRepositoryMockBuilder::getReturnDefaultProjectOnUpdate();
        $issuePersistenceAdapter = $this->constructPersistenceAdapter($issueEntityRepository);
        $issue = IssueTestBuilder::getDefaultPersisted();
        $issue->setTitle(IssueTestBuilder::NOT_DEFAULT_TITLE);
        $issue->setTime(IssueTestBuilder::NOT_DEFAULT_TIME);
        $issuePersistenceAdapter->update($issue);
        $this->assertTrue($issue->getId() == IssueEntityTestBuilder::DEFAULT_ID);
        $this->assertEquals($issue->getTitle(), IssueTestBuilder::NOT_DEFAULT_TITLE);
        $this->assertEquals($issue->getTime(), IssueTestBuilder::NOT_DEFAULT_TIME);
    }
}