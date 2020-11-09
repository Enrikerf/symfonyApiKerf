<?php

namespace App\Tests\Unitary\Application\Service;

use App\Adapter\out\Persistence\Doctrine\Adapter\ProjectPersistenceAdapter;
use App\Application\Model\ResponseCode;
use App\Application\Service\GetProjectService;
use App\Domain\Project\Project;
use App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Repository\ProjectEntityRepositoryMockBuilder;
use App\Tests\Unitary\Adapter\out\Serializer\SymfonySerializerBuilder;
use App\Tests\Unitary\Domain\Project\ProjectTestBuilder;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;


class GetProjectServiceTest extends TestCase
{

    use MockeryPHPUnitIntegration;

    private function constructPersistenceAdapter($projectEntityRepository)
    {
        $mapper = SymfonySerializerBuilder::get();

        return new ProjectPersistenceAdapter($projectEntityRepository, $mapper);
    }

    private function constructGetProjectService($persistenceAdapter)
    {
        return new GetProjectService($persistenceAdapter);
    }

    public function testGetProjectQueryReturnServerErrorCodeOnPortException(): void
    {
        $persistenceAdapter = $this->constructPersistenceAdapter(ProjectEntityRepositoryMockBuilder::getReturnExceptionOnFind());
        $getProjectService = $this->constructGetProjectService($persistenceAdapter);
        $return = $getProjectService->getProjectQuery(ProjectTestBuilder::PROJECT_ID);
        $this->assertEquals($return->getResponseCode(), ResponseCode::PERSISTENCE_EXCEPTION);
    }

    public function testGetProjectQueryReturnNotFoundCodeOnNotFound(): void
    {
        $persistenceAdapter = $this->constructPersistenceAdapter(ProjectEntityRepositoryMockBuilder::getReturnNullOnFind());
        $getProjectService = $this->constructGetProjectService($persistenceAdapter);
        $return = $getProjectService->getProjectQuery(ProjectTestBuilder::PROJECT_ID);
        $this->assertEquals($return->getResponseCode(), ResponseCode::NOT_FOUND);
    }

    public function testGetProjectQueryReturnOkCodeOnSuccessAndMessageWithArrayAndProjectOnTheFirstElement(): void
    {
        $persistenceAdapter = $this->constructPersistenceAdapter(ProjectEntityRepositoryMockBuilder::getReturnDefaultProjectOnFind());
        $getProjectService = $this->constructGetProjectService($persistenceAdapter);
        $return = $getProjectService->getProjectQuery(ProjectTestBuilder::PROJECT_ID);
        $this->assertEquals($return->getResponseCode(), ResponseCode::OK);
        $this->assertInstanceOf(Project::class,$return->getMessage()[0]);
    }
}