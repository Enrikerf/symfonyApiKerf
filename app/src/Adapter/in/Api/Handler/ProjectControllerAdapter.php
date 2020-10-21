<?php

namespace App\Adapter\in\Api\Handler;

use OpenAPI\Server\Api\ProjectsApiInterface;
use OpenAPI\Server\Model\CreateProject;
use OpenAPI\Server\Model\Project;
use OpenAPI\Server\Model\ProjectName;

class ProjectControllerAdapter implements ProjectsApiInterface
{

    /**
     * @inheritDoc
     */
    public function projectProjectIdGet($projectId, &$responseCode, array &$responseHeaders)
    {
        return new Project(['id' => 1, 'name' => "name"]);
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
        return [new Project([ 'name' => "name"])];
    }

    /**
     * @inheritDoc
     */
    public function projectsPost(CreateProject $createProject, &$responseCode, array &$responseHeaders)
    {
        return new Project(['id' => 1, 'name' => "name"]);
    }
}