<?php

namespace App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Entity;

use App\Adapter\out\Persistence\Doctrine\Entity\ProjectEntity;


class ProjectEntityTestBuilder
{

    public const DEFAULT_NAME = "default persisted name";
    public const DEFAULT_ID = 12345;
    public const DEFAULT_ISSUE_COUNT = 9876;

    public static function getDefaultProject()
    {
        return (new ProjectEntity())
            ->setId(self::DEFAULT_ID)
            ->setName(self::DEFAULT_NAME)
            ->setIssueCount(self::DEFAULT_ISSUE_COUNT);
    }
}