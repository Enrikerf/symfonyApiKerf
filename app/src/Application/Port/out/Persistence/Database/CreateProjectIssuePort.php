<?php

namespace App\Application\Port\out\Persistence\Database;

use App\Domain\Issue\Issue;
use Exception;


interface CreateProjectIssuePort
{

    /**
     * @param int $id
     *
     * @return Issue|null
     * @throws Exception
     */
    public function get(int $id): ?Issue;

    /**
     * @param Issue $issue
     *
     * @throws Exception
     */
    public function save(Issue &$issue): void;
}