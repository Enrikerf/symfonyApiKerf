<?php

namespace App\Application\Port\in\UpdateProject;

interface UpdateProjectUseCase
{

    public function update(UpdateProjectCommand $updateProjectCommand): UpdateProjectResponse;
}