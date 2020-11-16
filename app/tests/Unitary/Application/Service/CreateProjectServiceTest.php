<?php

namespace App\Tests\Unitary\Application\Service;

use App\Application\Model\ResponseCode;
use App\Application\Port\in\CreateProject\CreateProjectCommand;
use App\Application\Port\in\CreateProject\CreateProjectResponse;
use App\Application\Service\CreateProjectService;
use App\Tests\Unitary\Application\Port\out\Persistence\Database\CreateProjectPortMockBuilder;
use App\Tests\Unitary\Domain\Project\ProjectTestBuilder;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;


class CreateProjectServiceTest extends TestCase
{

    use MockeryPHPUnitIntegration;

    private function getTestedClass($portMock)
    {
        return new CreateProjectService($portMock);
    }

    public function testCreateReturnCreatedCodeAndCorrectProjectOnMessage(): void
    {
        $createProjectService = $this->getTestedClass(CreateProjectPortMockBuilder::getReturnProjectPersistedOnSave());
        $return = $createProjectService->create(new CreateProjectCommand(ProjectTestBuilder::DEFAULT_PROJECT_NAME));
        $this->assertEquals(ResponseCode::OBJECT_CREATED, $return->getResponseCode());
        $this->assertEquals(ProjectTestBuilder::DEFAULT_PROJECT_ID, $return->getMessage()[0]->getId());
        $this->assertEquals(ProjectTestBuilder::DEFAULT_PROJECT_NAME, $return->getMessage()[0]->getName());
    }

    public function testCreateProjectOnSaveExceptionReturnException(): void
    {
        $createProjectService = $this->getTestedClass(CreateProjectPortMockBuilder::getReturnExceptionOnSave());
        $return = $createProjectService->create(new CreateProjectCommand(ProjectTestBuilder::DEFAULT_PROJECT_NAME));
        $this->assertEquals(ResponseCode::PERSISTENCE_EXCEPTION, $return->getResponseCode());
    }
}