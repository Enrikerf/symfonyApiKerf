<?php

namespace App\Application\Port\out\Persistence\Database;

use App\Domain\Project\Project;
use Exception;


interface GetProjectsByPort
{

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return array
     * @throws Exception
     */
    public function getBy(array $criteria = [], array $orderBy = null, int $limit = null, int $offset = null): array;
}