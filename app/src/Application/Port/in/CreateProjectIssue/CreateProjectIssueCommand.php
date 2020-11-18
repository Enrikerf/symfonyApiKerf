<?php

namespace App\Application\Port\in\CreateProjectIssue;

class CreateProjectIssueCommand
{

    private int      $projectId;
    private string   $type;
    private string   $title;
    private ?int     $parentId;

    /**
     * CreateProjectIssueCommand constructor.
     *
     * @param int      $projectId
     * @param string   $type
     * @param string   $title
     * @param int|null $parentId
     */
    public function __construct(int $projectId, string $type, string $title, ?int $parentId)
    {
        $this->projectId = $projectId;
        $this->type = $type;
        $this->title = $title;
        $this->parentId = $parentId;
    }

    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->projectId;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return int|null
     */
    public function getParentId(): ?int
    {
        return $this->parentId;
    }
}