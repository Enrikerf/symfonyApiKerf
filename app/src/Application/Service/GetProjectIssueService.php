<?php

namespace App\Application\Service;

use App\Application\Model\ResponseCode;
use App\Application\Port\in\GetProjectIssue\GetProjectIssueQuery;
use App\Application\Port\in\GetProjectIssue\GetProjectIssueQueryResponse;
use App\Application\Port\out\Persistence\Database\GetProjectIssuePort;
use Exception;


class GetProjectIssueService implements GetProjectIssueQuery
{

    private GetProjectIssuePort $getProjectPort;

    public function __construct(GetProjectIssuePort $getProjectPort)
    {
        $this->getProjectPort = $getProjectPort;
    }

    public function getProjectIssueQuery(int $projectId): GetProjectIssueQueryResponse
    {
        try {
            return new GetProjectIssueQueryResponse(ResponseCode::OK, [$this->getProjectPort->get($projectId)]);
        } catch (Exception $e) {
            return new GetProjectIssueQueryResponse(ResponseCode::PERSISTENCE_EXCEPTION, [$e->getMessage()]);
        }
    }
}