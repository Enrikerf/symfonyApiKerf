<?php

namespace App\Tests\Integration\Application\Service;

use App\Application\Model\ResponseCode;
use App\Application\Service\GetProjectIssueService;
use App\Application\Service\GetProjectService;
use App\Domain\Issue\Issue;
use App\Domain\Project\Project;
use App\Tests\Unitary\Application\Port\out\Persistence\Database\GetProjectIssuePortMockBuilder;
use App\Tests\Unitary\Application\Port\out\Persistence\Database\GetProjectPortMockBuilder;
use App\Tests\Unitary\Domain\Project\ProjectTestBuilder;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;


class GetProjectIssueServiceTest extends TestCase
{

    private function constructGetProjectService($persistenceAdapter): GetProjectIssueService
    {
        return new GetProjectIssueService($persistenceAdapter);
    }

    public function testGetProjectQueryReturnServerErrorCodeOnPortException(): void
    {
        $getProjectIssueService = $this->constructGetProjectService(GetProjectIssuePortMockBuilder::getExceptionOnGet());
        $return = $getProjectIssueService->getProjectIssueQuery(ProjectTestBuilder::DEFAULT_PROJECT_ID);
        $this->assertEquals($return->getResponseCode(), ResponseCode::PERSISTENCE_EXCEPTION);
    }

    public function testGetProjectQueryReturnEmptyArrayOnNoIssuesFound(): void
    {
        $getProjectService = $this->constructGetProjectService(GetProjectIssuePortMockBuilder::getEmpty());
        $return = $getProjectService->getProjectIssueQuery(ProjectTestBuilder::DEFAULT_PROJECT_ID);
        $this->assertEquals($return->getResponseCode(), ResponseCode::OK);
        $this->assertEmpty($return->getMessage()[0]);
    }

    public function testGetProjectQueryReturnOkCodeOnSuccessAndMessageWithArrayOfIssues(): void
    {
        $getProjectService = $this->constructGetProjectService(GetProjectIssuePortMockBuilder::getDefault());
        $return = $getProjectService->getProjectIssueQuery(ProjectTestBuilder::DEFAULT_PROJECT_ID);
        $this->assertEquals($return->getResponseCode(), ResponseCode::OK);
        $this->assertIsArray($return->getMessage()[0]);
        $this->assertInstanceOf(Issue::class, $return->getMessage()[0][0]);
    }
}