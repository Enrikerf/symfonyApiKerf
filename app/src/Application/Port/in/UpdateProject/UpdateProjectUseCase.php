<?php

namespace App\Application\Port\in\UpdateProject;

interface UpdateProjectUseCase
{

    public function update(UpdateProjectCommand $createCommand): UpdateProjectResponse;
}