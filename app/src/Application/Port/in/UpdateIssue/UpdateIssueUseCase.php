<?php

namespace App\Application\Port\in\UpdateIssue;

interface UpdateIssueUseCase
{

    public function update(UpdateIssueCommand $updateIssueCommand): UpdateIssueResponse;
}