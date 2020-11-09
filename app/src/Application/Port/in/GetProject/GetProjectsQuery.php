<?php

namespace App\Application\Port\in\GetProject;

interface GetProjectsQuery
{

    public function getProjectQuery(int $id): GetProjectQueryResponse;
}