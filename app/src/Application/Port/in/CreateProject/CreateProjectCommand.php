<?php

namespace App\Application\Port\in\CreateProject;

class CreateProjectCommand
{
    private string   $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return int|string
     */
    public function getName()
    {
        return $this->name;
    }




}