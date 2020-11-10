<?php

namespace App\Adapter\in\Api\Handler;

use App\Application\Model\ResponseCode;
use App\Application\Port\in\CreateProject\CreateProjectCommand;
use App\Application\Port\in\CreateProject\CreateProjectUseCase;
use App\Application\Port\in\GetProject\GetProjectQuery;
use App\Application\Port\in\GetProjectsBy\GetProjectsByQuery;
use App\Application\Service\CreateProjectService;
use OpenAPI\Server\Api\ProjectsApiInterface;
use OpenAPI\Server\Model\CreateProject;
use OpenAPI\Server\Model\Project;
use OpenAPI\Server\Model\ProjectName;


class ProjectControllerAdapter implements ProjectsApiInterface
{

    private GetProjectQuery            $getProjectService;
    private GetProjectsByQuery $getProjectsByCriteriaService;
    private CreateProjectUseCase         $createProjectService;

    public function __construct(
        GetProjectQuery $getProjectService,
        GetProjectsByQuery $getProjectsByCriteriaService,
        CreateProjectUseCase $createProjectService
    ) {
        $this->getProjectService = $getProjectService;
        $this->getProjectsByCriteriaService = $getProjectsByCriteriaService;
        $this->createProjectService = $createProjectService;
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
        return new Project(['id' => 1, 'name' => "name"]);
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