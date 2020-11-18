<?php

namespace App\Application\Port\out\Persistence\Database;

use App\Domain\Issue\Issue;
use Exception;


interface GetIssuePort
{

    /**
     * @param int $id
     *
     * @return Issue|null
     * @throws Exception
     */
    public function get(int $id): ?Issue;
}