<?php

namespace App\Adapter\in\Api\Handler;

use App\Application\Model\ResponseCode;
use App\Application\Service\GetProjectsByCriteriaService;
use App\Application\Service\GetProjectService;
use OpenAPI\Server\Api\ProjectsApiInterface;
use OpenAPI\Server\Model\CreateProject;
use OpenAPI\Server\Model\Project;
use OpenAPI\Server\Model\ProjectName;


class ProjectControllerAdapter implements ProjectsApiInterface
{

    private GetProjectService            $getProjectService;
    private GetProjectsByCriteriaService $getProjectsByCriteriaService;

    public function __construct(
        GetProjectService $getProjectService,
        GetProjectsByCriteriaService $getProjectsByCriteriaService
    ) {
        $this->getProjectService = $getProjectService;
        $this->getProjectsByCriteriaService = $getProjectsByCriteriaService;
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
        return new Project(['id' => 1, 'name' => "name"]);
    }
}