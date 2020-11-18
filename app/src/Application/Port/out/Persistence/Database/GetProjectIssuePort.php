<?php

namespace App\Application\Port\out\Persistence\Database;

use App\Domain\Issue\Issue;
use Exception;


interface GetProjectIssuePort
{

    /**
     * @param int $projectId
     *
     * @return array
     * @throws Exception
     */
    public function get(int $projectId): array;
}