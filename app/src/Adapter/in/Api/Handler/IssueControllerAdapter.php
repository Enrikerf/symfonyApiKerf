<?php

namespace App\Adapter\in\Api\Handler;

use App\Application\Model\ResponseCode;
use OpenAPI\Server\Api\IssuesApiInterface;
use OpenAPI\Server\Model\CreateIssue;
use OpenAPI\Server\Model\Time;


class IssueControllerAdapter implements IssuesApiInterface
{

    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function issueIdGet($id, &$responseCode, array &$responseHeaders)
    {
        $responseCode = ResponseCode::OK;

        return [
            "id" => 1,
            "project_id" => 1,
            "type" => "topic",
            "title" => "a parent issue",
            "time" => 5,
            "total_time" => 7.5,
            "childs" => [
                [
                    "id" => 2,
                    "type" => "config",
                    "title" => "a child issue",
                    "time" => 2.5,
                    "total_time" => 2.5,
                ],
            ],
        ];
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
}