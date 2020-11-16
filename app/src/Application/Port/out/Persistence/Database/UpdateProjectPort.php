<?php

namespace App\Application\Port\out\Persistence\Database;

use App\Domain\Project\Project;
use Exception;


interface UpdateProjectPort
{

    /**
     * @param int $id
     *
     * @return Project|null
     * @throws Exception
     */
    public function get(int $id):?Project;

    /**
     * @param Project $project
     *
     * @throws Exception
     */
    public function update(Project &$project): void;
}