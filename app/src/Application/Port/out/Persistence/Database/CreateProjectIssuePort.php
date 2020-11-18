<?php

namespace App\Application\Port\out\Persistence\Database;

use App\Domain\Issue\Issue;
use Exception;


interface CreateProjectIssuePort
{

    /**
     * @param Issue $issue
     *
     * @throws Exception
     */
    public function save(Issue &$issue): void;
}