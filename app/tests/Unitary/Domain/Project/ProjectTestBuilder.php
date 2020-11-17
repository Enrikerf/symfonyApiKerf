<?php

namespace App\Tests\Unitary\Domain\Project;

use App\Domain\Project\Project;
use App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Entity\ProjectEntityTestBuilder;
use phpDocumentor\Reflection\Types\Self_;


class ProjectTestBuilder
{

    const DEFAULT_PROJECT_NAME = "default domain Name";
    const DEFAULT_PROJECT_ID = 1;
    public const NOT_DEFAULT_NAME = "NOT_DEFAULT_NAME";
    public const NOT_DEFAULT_ISSUE_COUNT = 1234;
    private ?string $name       = null;
    private ?int    $id         = null;
    private ?int    $issueCount = null;

    public static function getProjectTest()
    {
        return new ProjectTestBuilder();
    }

    public static function getDefaultNewProject()
    {
        return new Project(self::DEFAULT_PROJECT_NAME);
    }

    public static function getDefaultPersistedProject()
    {
        return self::getProjectTest()->name(self::DEFAULT_PROJECT_NAME)->id(ProjectEntityTestBuilder::DEFAULT_ID)->build();
    }

    public function name($string)
    {
        $this->name = $string;

        return $this;
    }

    public function id($id)
    {
        $this->id = $id;

        return $this;
    }

    public function build()
    {
        $project = new Project($this->name);
        ($this->id) ? $project->setId($this->id) : null;
        ($this->issueCount) ? $project->setIssueCount($this->issueCount) : null;

        return $project;
    }
}