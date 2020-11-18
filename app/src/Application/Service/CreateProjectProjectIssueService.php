<?php

namespace App\Application\Service;

use App\Application\Model\ResponseCode;
use App\Application\Port\in\CreateProjectIssue\CreateProjectIssueCommand;
use App\Application\Port\in\CreateProjectIssue\CreateProjectIssueResponse;
use App\Application\Port\in\CreateProjectIssue\CreateProjectIssueUseCase;
use Exception;


class CreateProjectProjectIssueService implements CreateProjectIssueUseCase
{

    public function create(CreateProjectIssueCommand $createCommand): CreateProjectIssueResponse
    {
        try{

        }catch (Exception $exception){
            return new CreateProjectIssueResponse(ResponseCode::PERSISTENCE_EXCEPTION, []);
        }
    }
}