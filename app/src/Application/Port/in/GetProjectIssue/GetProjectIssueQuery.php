<?php

namespace App\Application\Port\in\GetProjectIssue;

interface GetProjectIssueQuery
{

    public function getProjectIssueQuery(int $projectId): GetProjectIssueQueryResponse;
}