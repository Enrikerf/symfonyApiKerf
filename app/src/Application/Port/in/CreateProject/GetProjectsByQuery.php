<?php

namespace App\Application\Port\in\CreateProject;

interface CreateProject

{

    public function create($createCommand): CreateProjectResponse;
}