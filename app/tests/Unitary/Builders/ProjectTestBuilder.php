<?php

namespace App\Tests\Unitary\Builders;

use App\Domain\Project\Project;


class ProjectTestBuilder
{
    private string $name;

    public static function getExamBuilder(){
        return new ProjectTestBuilder();
    }

    public function name($string){
        $this->name = $string;
        return $this;
    }
    public function build(){
        return new Project($this->name);
    }
}