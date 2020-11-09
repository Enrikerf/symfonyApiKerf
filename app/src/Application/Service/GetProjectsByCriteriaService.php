<?php

namespace App\Application\Service;

use App\Application\Model\ResponseCode;
use App\Application\Port\in\GetProject\GetProjectQueryResponse;
use App\Application\Port\in\GetProject\GetProjectQuery;
use App\Application\Port\in\GetProjectsBy\GetProjectsByQuery;
use App\Application\Port\in\GetProjectsBy\GetProjectsByQueryResponse;
use App\Application\Port\out\Persistence\Database\GetProjectPort;
use App\Application\Port\out\Persistence\Database\GetProjectsByPort;
use Exception;


class GetProjectsByCriteriaService implements GetProjectsByQuery
{

    private GetProjectsByPort $getProjectsByPort;

    public function __construct(GetProjectsByPort $getProjectsByPort)
    {
        $this->getProjectsByPort = $getProjectsByPort;
    }

    public function getProjectQuery(array $criteria = [], array $orderBy = null, int $limit = null, int $offset = null): GetProjectsByQueryResponse
    {
        try {
            $response = $this->getProjectsByPort->getBy($criteria,$orderBy,$limit,$offset);
            if (is_array($response)) {
                return new GetProjectsByQueryResponse(ResponseCode::OK, [$response]);
            } else {
                return new GetProjectsByQueryResponse(ResponseCode::DOMAIN_EXCEPTION, []);
            }
        } catch (Exception $e) {
            return new GetProjectsByQueryResponse(ResponseCode::PERSISTENCE_EXCEPTION, [$e->getMessage()]);
        }
    }
}