<?php

namespace App\Tests\Unitary\Application\Service;

use App\Application\Model\ResponseCode;
use App\Application\Port\in\UpdateProject\UpdateProjectCommand;
use App\Application\Service\UpdateProjectService;
use App\Tests\Unitary\Application\Port\out\Persistence\Database\UpdateProjectPortMockBuilder;
use App\Tests\Unitary\Domain\Project\ProjectTestBuilder;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;


class UpdateProjectServiceTest extends TestCase
{

    use MockeryPHPUnitIntegration;

    private function getTestedClass($portMock)
    {
        return new UpdateProjectService($portMock);
    }

    public function testUpdateReturnCreatedCodeAndCorrectProjectOnMessage(): void
    {
        $createProjectService = $this->getTestedClass(UpdateProjectPortMockBuilder::getReturnProjectPersistedOnUpdate());
        $return = $createProjectService->update(new UpdateProjectCommand(ProjectTestBuilder::DEFAULT_PROJECT_ID,
            ProjectTestBuilder::DEFAULT_PROJECT_NAME));
        $this->assertEquals(ResponseCode::OK, $return->getResponseCode());
        $this->assertEquals(ProjectTestBuilder::DEFAULT_PROJECT_ID, $return->getMessage()[0]->getId());
        $this->assertEquals(ProjectTestBuilder::DEFAULT_PROJECT_NAME, $return->getMessage()[0]->getName());
    }

    public function testUpdateProjectOnUpdateExceptionReturnException(): void
    {
        $createProjectService = $this->getTestedClass(UpdateProjectPortMockBuilder::getReturnExceptionOnUpdate());
        $return = $createProjectService->update(new UpdateProjectCommand(ProjectTestBuilder::DEFAULT_PROJECT_ID,
            ProjectTestBuilder::DEFAULT_PROJECT_NAME));
        $this->assertEquals(ResponseCode::PERSISTENCE_EXCEPTION, $return->getResponseCode());
    }
}