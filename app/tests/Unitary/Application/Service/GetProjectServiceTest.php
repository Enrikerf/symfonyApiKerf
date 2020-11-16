<?php

namespace App\Tests\Integration\Application\Service;

use App\Application\Model\ResponseCode;
use App\Application\Service\GetProjectService;
use App\Domain\Project\Project;
use App\Tests\Unitary\Application\Port\out\Persistence\Database\GetProjectPortMockBuilder;
use App\Tests\Unitary\Domain\Project\ProjectTestBuilder;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;


class GetProjectServiceTest extends TestCase
{

    use MockeryPHPUnitIntegration;

    private function constructGetProjectService($persistenceAdapter)
    {
        return new GetProjectService($persistenceAdapter);
    }

    public function testGetProjectQueryReturnServerErrorCodeOnPortException(): void
    {
        $getProjectService = $this->constructGetProjectService(GetProjectPortMockBuilder::getExceptionOnGet());
        $return = $getProjectService->getProjectQuery(ProjectTestBuilder::DEFAULT_PROJECT_ID);
        $this->assertEquals($return->getResponseCode(), ResponseCode::PERSISTENCE_EXCEPTION);
    }

    public function testGetProjectQueryReturnNotFoundCodeOnNotFound(): void
    {
        $getProjectService = $this->constructGetProjectService(GetProjectPortMockBuilder::getNull());
        $return = $getProjectService->getProjectQuery(ProjectTestBuilder::DEFAULT_PROJECT_ID);
        $this->assertEquals($return->getResponseCode(), ResponseCode::NOT_FOUND);
    }

    public function testGetProjectQueryReturnOkCodeOnSuccessAndMessageWithProject(): void
    {
        $getProjectService = $this->constructGetProjectService(GetProjectPortMockBuilder::getDefault());
        $return = $getProjectService->getProjectQuery(ProjectTestBuilder::DEFAULT_PROJECT_ID);
        $this->assertEquals($return->getResponseCode(), ResponseCode::OK);
        $this->assertInstanceOf(Project::class, $return->getMessage()[0]);
    }
}