<?php

namespace App\Application\Port\in\GetIssue;

interface GetIssueQuery
{

    public function getIssueQuery(int $id): GetIssueQueryResponse;
}