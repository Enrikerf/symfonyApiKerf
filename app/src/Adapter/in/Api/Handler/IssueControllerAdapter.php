<?php

namespace App\Adapter\in\Api\Handler;

use App\Application\Model\ResponseCode;
use App\Application\Port\in\CreateProjectIssue\CreateProjectIssueCommand;
use App\Application\Port\in\CreateProjectIssue\CreateProjectIssueUseCase;
use App\Application\Port\in\GetIssue\GetIssueQuery;
use App\Application\Port\out\Persistence\Database\GetIssuePort;
use OpenAPI\Server\Api\IssuesApiInterface;
use OpenAPI\Server\Model\CreateIssue;
use OpenAPI\Server\Model\Time;


class IssueControllerAdapter implements IssuesApiInterface
{

    private GetIssueQuery             $getIssueQuery;
    private CreateProjectIssueUseCase $createProjectIssue;

    /**
     * IssueControllerAdapter constructor.
     *
     * @param GetIssueQuery             $getIssuePort
     * @param CreateProjectIssueUseCase $createProjectIssue
     */
    public function __construct(GetIssueQuery $getIssuePort, CreateProjectIssueUseCase $createProjectIssue)
    {
        $this->getIssueQuery = $getIssuePort;
        $this->createProjectIssue = $createProjectIssue;
    }

    /**
     * @inheritDoc
     */
    public function issueIdGet($id, &$responseCode, array &$responseHeaders)
    {
        $response = $this->getIssueQuery->getIssueQuery($id);
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
    public function issueIdPatch($id, Time $time, &$responseCode, array &$responseHeaders)
    {
        $responseCode = ResponseCode::OK;

        return [
            [
                "id" => 1,
                "project_id" => 1,
                "type" => "dev",
                "title" => "a parent issue",
                "time" => 5,
                "total_time" => 7.5,
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function projectsProjectIdIssuesGet($projectId, &$responseCode, array &$responseHeaders)
    {
        $responseCode = ResponseCode::OK;

        return [
            [
                "id" => 1,
                "project_id" => 1,
                "type" => "dev",
                "title" => "a parent issue",
                "time" => 5,
                "total_time" => 7.5,
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function projectsProjectIdIssuesPost(
        $projectId,
        CreateIssue $createIssue,
        &$responseCode,
        array &$responseHeaders
    ) {
        $createProjectCommand = new CreateProjectIssueCommand(
            $projectId,
            $createIssue->getTitle(),
            $createIssue->getType(),
            $createIssue->getParentId()
        );
        $response = $this->createProjectIssue->create($createProjectCommand);
        $responseCode = $response->getResponseCode();
        if ($responseCode === ResponseCode::OBJECT_CREATED) {
            return $response->getMessage()[0];
        } else {
            return $response->getMessage();
        }
    }
}