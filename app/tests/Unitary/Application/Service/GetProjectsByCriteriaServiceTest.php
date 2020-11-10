<?php

namespace App\Tests\Unitary\Application\Service;

use App\Adapter\out\Persistence\Doctrine\Adapter\ProjectPersistenceAdapter;
use App\Application\Model\ResponseCode;
use App\Application\Service\GetProjectsByCriteriaService;
use App\Domain\Project\Project;
use App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Repository\ProjectEntityRepositoryMockBuilder;
use App\Tests\Unitary\Adapter\out\Serializer\SymfonySerializerMockBuilder;
use App\Tests\Unitary\Adapter\out\Serializer\SymfonySerializerTestBuilder;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;


class GetProjectsByCriteriaServiceTest extends TestCase
{

    use MockeryPHPUnitIntegration;

    private function constructPersistenceAdapter($projectEntityRepository)
    {
        $mapper = SymfonySerializerTestBuilder::get();

        return new ProjectPersistenceAdapter($projectEntityRepository, $mapper);
    }

    private function constructGetProjectService($persistenceAdapter)
    {
        return new GetProjectsByCriteriaService($persistenceAdapter);
    }

    private function constructPersistenceAdapterWithErrorOnSerializer($projectEntityRepository)
    {
        $mapper = SymfonySerializerMockBuilder::getMockWithDenormalizeReturnNull();

        return new ProjectPersistenceAdapter($projectEntityRepository, $mapper);
    }

    public function testGetProjectsByCriteriaQueryReturnServerErrorCodeOnPortException(): void
    {
        $persistenceAdapter = $this->constructPersistenceAdapter(ProjectEntityRepositoryMockBuilder::getReturnExceptionOnGetBy());
        $getProjectService = $this->constructGetProjectService($persistenceAdapter);
        $return = $getProjectService->getProjectQuery([]);
        $this->assertEquals($return->getResponseCode(), ResponseCode::PERSISTENCE_EXCEPTION);
    }

    public function testGetProjectsByCriteriaQueryReturnServerErrorCodeOnSerializerError(): void
    {
        $persistenceAdapter = $this->constructPersistenceAdapterWithErrorOnSerializer(ProjectEntityRepositoryMockBuilder::getReturnExceptionOnGetBy());
        $getProjectService = $this->constructGetProjectService($persistenceAdapter);
        $return = $getProjectService->getProjectQuery([]);
        $this->assertEquals($return->getResponseCode(), ResponseCode::DOMAIN_EXCEPTION);
    }

    public function testGetProjectsByCriteriaQueryReturnOkCodeOnSuccessAndArrayOfProjectsOnMessageResponse(): void
    {
        $persistenceAdapter = $this->constructPersistenceAdapter(ProjectEntityRepositoryMockBuilder::getReturnArrayOfProjectOnGetBy());
        $getProjectService = $this->constructGetProjectService($persistenceAdapter);
        $return = $getProjectService->getProjectQuery([]);
        $this->assertEquals($return->getResponseCode(), ResponseCode::OK);
        $this->assertIsArray($return->getMessage());
        $this->assertInstanceOf(Project::class,$return->getMessage()[0][0] );
    }
}