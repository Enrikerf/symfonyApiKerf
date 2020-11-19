<?php

namespace App\Application\Service;

use App\Application\Model\ResponseCode;
use App\Application\Port\in\CreateProjectIssue\CreateProjectIssueCommand;
use App\Application\Port\in\CreateProjectIssue\CreateProjectIssueResponse;
use App\Application\Port\in\CreateProjectIssue\CreateProjectIssueUseCase;
use App\Application\Port\out\Persistence\Database\CreateProjectIssuePort;
use App\Application\Port\out\Persistence\Database\GetProjectPort;
use App\Domain\Issue\Issue;
use Exception;


class CreateProjectProjectIssueService implements CreateProjectIssueUseCase
{

    private GetProjectPort         $getProjectPort;
    private CreateProjectIssuePort $createProjectIssuePort;

    public function __construct(
        GetProjectPort $getProjectPort,
        CreateProjectIssuePort $createProjectIssuePort
    ) {
        $this->getProjectPort = $getProjectPort;
        $this->createProjectIssuePort = $createProjectIssuePort;
    }

    public function create(CreateProjectIssueCommand $createCommand): CreateProjectIssueResponse
    {
        try {
            if ($project = $this->getProjectPort->get($createCommand->getProjectId())) {
                if ($createCommand->getParentId()) {
                    $parentIssue = $this->createProjectIssuePort->get($createCommand->getParentId());
                    if (!$parentIssue || $parentIssue->getType() !== Issue::TYPE_TOPIC) {
                        return new CreateProjectIssueResponse(ResponseCode::BAD_REQUEST, []);
                    }
                }
                $issue = new Issue(
                    $createCommand->getProjectId(),
                    $createCommand->getTitle(),
                    $createCommand->getType(),
                    $createCommand->getParentId()
                );
                $this->createProjectIssuePort->save($issue);

                return new CreateProjectIssueResponse(ResponseCode::OBJECT_CREATED, [$issue]);
            } else {
                return new CreateProjectIssueResponse(ResponseCode::BAD_REQUEST, []);
            }
        } catch (Exception $exception) {
            return new CreateProjectIssueResponse(ResponseCode::DOMAIN_EXCEPTION, []);
        }
    }
}