<?php

namespace App\Application\Port\out\Persistence\Database;

use App\Domain\Project\Project;
use Exception;


interface CreateProjectPort
{

    /**
     * @param Project $project
     *
     * @return Project|null
     * @throws Exception
     */
    public function save(Project $project): ?Project;
}