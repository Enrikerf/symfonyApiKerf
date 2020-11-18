<?php

namespace App\Application\Port\out\Persistence\Database;

use App\Domain\Issue\Issue;
use Exception;


interface UpdateIssuePort
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
    public function update(Issue &$issue): void;
}