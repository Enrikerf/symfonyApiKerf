<?php

namespace App\Tests\Unitary\Domain\Project;

use App\Domain\Project\Project;
use phpDocumentor\Reflection\Types\Self_;


class ProjectTestBuilder
{

    const DEFAULT_PROJECT_NAME = "defaultName";
    const DEFAULT_PROJECT_ID = 1;
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
        return self::getProjectTest()->name(self::DEFAULT_PROJECT_NAME)->id(self::DEFAULT_PROJECT_ID)->build();
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