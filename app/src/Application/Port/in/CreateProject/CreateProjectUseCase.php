<?php

namespace App\Application\Port\in\CreateProject;

interface CreateProjectUseCase
{

    public function create(CreateProjectCommand $createCommand): CreateProjectResponse;
}