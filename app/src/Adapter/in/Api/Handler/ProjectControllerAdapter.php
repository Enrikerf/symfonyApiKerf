<?php

namespace App\Adapter\in\Api\Handler;

use App\Application\Model\ResponseCode;
use App\Application\Port\in\CreateProject\CreateProjectCommand;
use App\Application\Port\in\CreateProject\CreateProjectUseCase;
use App\Application\Port\in\GetProject\GetProjectQuery;
use App\Application\Port\in\GetProjectsBy\GetProjectsByQuery;
use App\Application\Port\in\UpdateProject\UpdateProjectCommand;
use App\Application\Port\in\UpdateProject\UpdateProjectUseCase;
use OpenAPI\Server\Api\ProjectsApiInterface;
use OpenAPI\Server\Model\CreateProject;
use OpenAPI\Server\Model\ProjectName;


class ProjectControllerAdapter implements ProjectsApiInterface
{

    private GetProjectQuery              $getProjectService;
    private GetProjectsByQuery           $getProjectsByCriteriaService;
    private CreateProjectUseCase         $createProjectService;
    private UpdateProjectUseCase         $updateProjectService;

    public function __construct(
        GetProjectQuery $getProjectService,
        GetProjectsByQuery $getProjectsByCriteriaService,
        CreateProjectUseCase $createProjectService,
        UpdateProjectUseCase $updateProjectService
    ) {
        $this->getProjectService = $getProjectService;
        $this->getProjectsByCriteriaService = $getProjectsByCriteriaService;
        $this->createProjectService = $createProjectService;
        $this->updateProjectService = $updateProjectService;
    }

    /**
     * @inheritDoc
     */
    public function projectProjectIdGet($projectId, &$responseCode, array &$responseHeaders)
    {
        $response = $this->getProjectService->getProjectQuery($projectId);
        $responseCode = $response->getResponseCode();
        if ($responseCode === ResponseCode::OK) {
            return $response->getMessage()[0];
        } else {
            return $response->getMessage();
        }
    }

    /**
     * @inheritDoc
     */
    public function projectProjectIdPut($projectId, ProjectName $projectName, &$responseCode, array &$responseHeaders)
    {
        $updateProjectCommand = new UpdateProjectCommand($projectId, $projectName->getName());
        $response = $this->updateProjectService->update($updateProjectCommand);
        $responseCode = $response->getResponseCode();
        if ($responseCode === ResponseCode::OK) {
            return $response->getMessage()[0];
        } else {
            return $response->getMessage();
        }
    }

    /**
     * @inheritDoc
     */
    public function projectsGet(&$responseCode, array &$responseHeaders)
    {
        $response = $this->getProjectsByCriteriaService->getProjectQuery();
        $responseCode = $response->getResponseCode();
        if ($responseCode === ResponseCode::OK) {
            return $response->getMessage()[0];
        } else {
            return $response->getMessage();
        }
    }

    /**
     * @inheritDoc
     */
    public function projectsPost(CreateProject $createProject, &$responseCode, array &$responseHeaders)
    {
        $createProjectCommand = new CreateProjectCommand($createProject->getTitle());
        $response = $this->createProjectService->create($createProjectCommand);
        $responseCode = $response->getResponseCode();
        if ($responseCode === ResponseCode::OBJECT_CREATED) {
            return $response->getMessage()[0];
        } else {
            return $response->getMessage();
        }
    }
}