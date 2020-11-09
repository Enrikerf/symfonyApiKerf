<?php

namespace App\Application\Port\in\GetProjectsBy;

interface GetProjectsByQuery
{

    public function getProjectQuery(array $criteria =[], array $orderBy = null, int $limit = null, int $offset = null): GetProjectsByQueryResponse;
}