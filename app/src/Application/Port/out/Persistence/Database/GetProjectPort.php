<?php

namespace App\Application\Port\out\Persistence\Database;

use App\Domain\Project\Project;
use Exception;


interface GetProjectPort
{
    /**
     * @param int $id
     *
     * @return Project|null
     * @throws Exception
     */
    public function get(int $id):?Project;
}