<?php

namespace App\Application\Port\in\GetProject;

interface GetProjectQuery
{

    public function getProjectQuery(int $id): GetProjectQueryResponse;
}