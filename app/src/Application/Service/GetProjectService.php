<?php

namespace App\Application\Service;

use App\Application\Model\ResponseCode;
use App\Application\Port\in\GetProject\GetProjectQueryResponse;
use App\Application\Port\in\GetProject\GetProjectQuery;
use App\Application\Port\out\Persistence\Database\GetProjectPort;
use Exception;


class GetProjectService implements GetProjectQuery
{

    private GetProjectPort $getProjectPort;

    public function __construct(GetProjectPort $getProjectPort)
    {
        $this->getProjectPort = $getProjectPort;
    }

    public function getProjectQuery(int $id): GetProjectQueryResponse
    {
        try {
            if ($this->getProjectPort->get($id)) {
                return new GetProjectQueryResponse(ResponseCode::OK, [$this->getProjectPort->get($id)]);
            } else {
                return new GetProjectQueryResponse(ResponseCode::NOT_FOUND, []);
            }
        } catch (Exception $e) {
            return new GetProjectQueryResponse(ResponseCode::PERSISTENCE_EXCEPTION, [$e->getMessage()]);
        }
    }
}