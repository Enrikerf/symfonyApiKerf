<?php

namespace App\Tests\Integration\Application\Service;

use App\Application\Model\ResponseCode;
use App\Application\Service\GetIssueService;
use App\Application\Service\GetProjectService;
use App\Domain\Issue\Issue;
use App\Domain\Project\Project;
use App\Tests\Unitary\Application\Port\out\Persistence\Database\GetIssuePortMockBuilder;
use App\Tests\Unitary\Application\Port\out\Persistence\Database\GetProjectIssuePortMockBuilder;
use App\Tests\Unitary\Application\Port\out\Persistence\Database\GetProjectPortMockBuilder;
use App\Tests\Unitary\Domain\Issue\IssueTestBuilder;
use App\Tests\Unitary\Domain\Project\ProjectTestBuilder;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;


class GetIssueServiceTest extends TestCase
{

    use MockeryPHPUnitIntegration;

    private function constructGetProjectService($persistenceAdapter)
    {
        return new GetIssueService($persistenceAdapter);
    }

    public function testGetProjectQueryReturnServerErrorCodeOnPortException(): void
    {
        $getProjectService = $this->constructGetProjectService(GetIssuePortMockBuilder::getExceptionOnGet());
        $return = $getProjectService->getIssueQuery(IssueTestBuilder::DEFAULT_PROJECT_ID);
        $this->assertEquals($return->getResponseCode(), ResponseCode::PERSISTENCE_EXCEPTION);
    }

    public function testGetProjectQueryReturnNotFoundCodeOnNotFound(): void
    {
        $getProjectService = $this->constructGetProjectService(GetIssuePortMockBuilder::getNull());
        $return = $getProjectService->getIssueQuery(ProjectTestBuilder::DEFAULT_PROJECT_ID);
        $this->assertEquals($return->getResponseCode(), ResponseCode::NOT_FOUND);
    }

    public function testGetProjectQueryReturnOkCodeOnSuccessAndMessageWithProject(): void
    {
        $getProjectService = $this->constructGetProjectService(GetIssuePortMockBuilder::getDefault());
        $return = $getProjectService->getIssueQuery(ProjectTestBuilder::DEFAULT_PROJECT_ID);
        $this->assertEquals($return->getResponseCode(), ResponseCode::OK);
        $this->assertInstanceOf(Issue::class, $return->getMessage()[0]);
    }
}