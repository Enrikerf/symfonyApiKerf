<?php

namespace App\Application\Service;

use App\Application\Model\ResponseCode;
use App\Application\Port\in\CreateProject\CreateProjectUseCase;
use App\Application\Port\in\CreateProject\CreateProjectCommand;
use App\Application\Port\in\CreateProject\CreateProjectResponse;
use App\Application\Port\in\GetProject\GetProjectQueryResponse;
use App\Application\Port\in\GetProject\GetProjectQuery;
use App\Application\Port\out\Persistence\Database\CreateProjectPort;
use App\Application\Port\out\Persistence\Database\GetProjectPort;
use App\Domain\Project\Project;
use Exception;


class CreateProjectService implements CreateProjectUseCase
{

    private CreateProjectPort $createProjectPort;

    public function __construct(CreateProjectPort $createProjectPort)
    {
        $this->createProjectPort = $createProjectPort;
    }

    public function create(CreateProjectCommand $createProjectCommand): CreateProjectResponse
    {
        try {
            $project = new Project($createProjectCommand->getName());
            $this->createProjectPort->save($project);

            return new CreateProjectResponse(ResponseCode::OBJECT_CREATED, [$project]);
        } catch (Exception $e) {
            return new CreateProjectResponse(ResponseCode::PERSISTENCE_EXCEPTION, []);
        }
    }
}