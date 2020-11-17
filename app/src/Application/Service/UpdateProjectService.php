<?php

namespace App\Application\Service;

use App\Application\Model\ResponseCode;
use App\Application\Port\in\UpdateProject\UpdateProjectCommand;
use App\Application\Port\in\UpdateProject\UpdateProjectResponse;
use App\Application\Port\in\UpdateProject\UpdateProjectUseCase;
use App\Application\Port\out\Persistence\Database\UpdateProjectPort;
use App\Domain\Project\Project;
use Exception;


class UpdateProjectService implements UpdateProjectUseCase
{

    private UpdateProjectPort $updateProjectPort;

    public function __construct(UpdateProjectPort $updateProjectPort)
    {
        $this->updateProjectPort = $updateProjectPort;
    }

    public function update(UpdateProjectCommand $updateProjectCommand): UpdateProjectResponse
    {
        try {
            if ($projectToUpdate = $this->updateProjectPort->get($updateProjectCommand->getId())) {
                $projectToUpdate->setName($updateProjectCommand->getName());
                $this->updateProjectPort->update($projectToUpdate);
            } else {
                return new UpdateProjectResponse(ResponseCode::NOT_FOUND, []);
            }

            return new UpdateProjectResponse(ResponseCode::OK, [$projectToUpdate]);
        } catch (Exception $e) {
            return new UpdateProjectResponse(ResponseCode::PERSISTENCE_EXCEPTION, []);
        }
    }
}