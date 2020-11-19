<?php

namespace App\Application\Service;

use App\Application\Model\ResponseCode;
use App\Application\Port\in\GetIssue\GetIssueQuery;
use App\Application\Port\in\GetIssue\GetIssueQueryResponse;
use App\Application\Port\in\GetProject\GetProjectQueryResponse;
use App\Application\Port\in\GetProject\GetProjectQuery;
use App\Application\Port\out\Persistence\Database\GetIssuePort;
use App\Application\Port\out\Persistence\Database\GetProjectPort;
use Exception;


class GetIssueService implements GetIssueQuery
{

    private GetIssuePort $getProjectPort;

    public function __construct(GetIssuePort $getProjectPort)
    {
        $this->getProjectPort = $getProjectPort;
    }

    public function getIssueQuery(int $id): GetIssueQueryResponse
    {
        try {
            if ($this->getProjectPort->get($id)) {
                return new GetIssueQueryResponse(ResponseCode::OK, [$this->getProjectPort->get($id)]);
            } else {
                return new GetIssueQueryResponse(ResponseCode::NOT_FOUND, []);
            }
        } catch (Exception $e) {
            return new GetIssueQueryResponse(ResponseCode::PERSISTENCE_EXCEPTION, [$e->getMessage()]);
        }
    }
}