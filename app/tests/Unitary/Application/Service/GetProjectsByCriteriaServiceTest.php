<?php

namespace App\Tests\Unitary\Application\Service;

use App\Adapter\out\Persistence\Doctrine\Adapter\ProjectPersistenceAdapter;
use App\Application\Model\ResponseCode;
use App\Application\Service\GetProjectsByCriteriaService;
use App\Domain\Project\Project;
use App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Repository\ProjectEntityRepositoryMockBuilder;
use App\Tests\Unitary\Adapter\out\Serializer\SymfonySerializerMockBuilder;
use App\Tests\Unitary\Adapter\out\Serializer\SymfonySerializerTestBuilder;
use App\Tests\Unitary\Application\Port\out\Persistence\Database\GetProjectsByPortMockBuilder;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;


class GetProjectsByCriteriaServiceTest extends TestCase
{

    use MockeryPHPUnitIntegration;

    private function getTestedClass($portMock)
    {
        return new GetProjectsByCriteriaService($portMock);
    }

    public function testGetProjectsByCriteriaQueryReturnServerErrorCodeOnPortException(): void
    {
        $getProjectService = $this->getTestedClass(GetProjectsByPortMockBuilder::getExceptionOnGetBy());
        $return = $getProjectService->getProjectQuery([]);
        $this->assertEquals($return->getResponseCode(), ResponseCode::PERSISTENCE_EXCEPTION);
    }

    public function testGetProjectsByCriteriaQueryReturnOkCodeOnSuccessAndArrayOfProjectsOnMessageResponse(): void
    {
        $getProjectService = $this->getTestedClass(GetProjectsByPortMockBuilder::getArray());
        $return = $getProjectService->getProjectQuery([]);
        $this->assertEquals($return->getResponseCode(), ResponseCode::OK);
        $this->assertIsArray($return->getMessage());
        $this->assertInstanceOf(Project::class, $return->getMessage()[0][0]);
    }
}