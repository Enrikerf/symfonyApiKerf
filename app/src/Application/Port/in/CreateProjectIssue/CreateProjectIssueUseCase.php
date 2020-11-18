<?php

namespace App\Application\Port\in\CreateProjectIssue;

interface CreateProjectIssueUseCase
{

    public function create(CreateProjectIssueCommand $createCommand): CreateProjectIssueResponse;
}