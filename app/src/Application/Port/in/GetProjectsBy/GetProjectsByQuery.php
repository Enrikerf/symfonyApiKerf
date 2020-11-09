<?php

namespace App\Application\Port\in\GetProjectsBy;

interface GetProjectsByQuery
{

    public function getProjectQuery(array $criteria): GetProjectsByQueryResponse;
}