<?php

namespace App\Tests\Unitary\Application\Service;

use App\Application\Model\ResponseCode;
use App\Application\Port\in\CreateProject\CreateProjectCommand;
use App\Application\Port\in\CreateProject\CreateProjectResponse;
use App\Application\Port\in\CreateProjectIssue\CreateProjectIssueCommand;
use App\Application\Service\CreateProjectProjectIssueService;
use App\Application\Service\CreateProjectService;
use App\Domain\Issue\Issue;
use App\Tests\Unitary\Application\Port\out\Persistence\Database\CreateProjectPortMockBuilder;
use App\Tests\Unitary\Domain\Issue\IssueTestBuilder;
use App\Tests\Unitary\Domain\Project\ProjectTestBuilder;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;


class CreateProjectIssueServiceTest extends TestCase
{

    use MockeryPHPUnitIntegration;

    private function getTestedClass()
    {
        return new CreateProjectProjectIssueService();
    }

    public function testOnParentWithTypeTopicReturnSuccessCode(): void
    {
        $createProjectService = $this->getTestedClass();
        $return = $createProjectService->create(
            new CreateProjectIssueCommand(
                IssueTestBuilder::DEFAULT_PROJECT_ID,
                IssueTestBuilder::DEFAULT_TYPE,
                IssueTestBuilder::DEFAULT_TITLE,
                IssueTestBuilder::PARENT_ID,
            )
        );
        $this->assertEquals(ResponseCode::OBJECT_CREATED, $return->getResponseCode());
        $this->assertInstanceOf(Issue::class, $return->getMessage()[0]);
    }

    public function testOnParentWithoutTypeTopicReturnBadRequest(): void
    {
        $createProjectService = $this->getTestedClass();
        $return = $createProjectService->create(
            new CreateProjectIssueCommand(
                IssueTestBuilder::DEFAULT_PROJECT_ID,
                IssueTestBuilder::DEFAULT_TYPE,
                IssueTestBuilder::DEFAULT_TITLE,
                IssueTestBuilder::PARENT_ID,
            )
        );
        $this->assertEquals(ResponseCode::BAD_REQUEST, $return->getResponseCode());
    }

    public function testOnNotFoundProjectIdReturnBadRequest(): void
    {
        $createProjectService = $this->getTestedClass();
        $return = $createProjectService->create(
            new CreateProjectIssueCommand(
                IssueTestBuilder::DEFAULT_PROJECT_ID,
                IssueTestBuilder::DEFAULT_TYPE,
                IssueTestBuilder::DEFAULT_TITLE,
                IssueTestBuilder::DEFAULT_PARENT_ID,
            )
        );
        $this->assertEquals(ResponseCode::BAD_REQUEST, $return->getResponseCode());
    }

    public function testOnExceptionReturnDomainExceptionCode(): void
    {
        $createProjectService = $this->getTestedClass();
        $return = $createProjectService->create(
            new CreateProjectIssueCommand(
                IssueTestBuilder::DEFAULT_PROJECT_ID,
                IssueTestBuilder::DEFAULT_TYPE,
                IssueTestBuilder::DEFAULT_TITLE,
                IssueTestBuilder::DEFAULT_PARENT_ID,
            )
        );
        $this->assertEquals(ResponseCode::DOMAIN_EXCEPTION, $return->getResponseCode());
    }
}