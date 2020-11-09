<?php

namespace App\Tests\Unitary\Domain\Project;

use App\Domain\Project\Project;
use phpDocumentor\Reflection\Types\Self_;


class ProjectTestBuilder
{

    const PROJECT_NAME = "defaultName";
    const PROJECT_ID = 1;
    private string $name;
    private int    $id;

    public static function getProjectTest()
    {
        return new ProjectTestBuilder();
    }

    public static function getDefaultNewProject()
    {
        return new Project(self::PROJECT_NAME);
    }

    public static function getDefaultPersistedProject()
    {
        return self::getProjectTest()->name(self::PROJECT_NAME)->id(self::PROJECT_ID)->build();
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
        return new Project($this->name);
    }
}