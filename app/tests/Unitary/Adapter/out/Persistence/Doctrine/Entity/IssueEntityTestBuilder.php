<?php

namespace App\Tests\Unitary\Adapter\out\Persistence\Doctrine\Entity;

use App\Adapter\out\Persistence\Doctrine\Entity\IssueEntity;
use App\Domain\Issue\Issue;
use Doctrine\Common\Collections\ArrayCollection;


class IssueEntityTestBuilder
{

    const DEFAULT_ID = null;
    const DEFAULT_PERSISTED_ID = 1;
    const DEFAULT_PROJECT_ID = 1;
    const DEFAULT_TITLE = 'DEFAULT DOMAIN TITLE';
    const DEFAULT_TYPE = Issue::TYPE_DEV;
    const DEFAULT_PARENT_ID = null;
    const PARENT_ID = 1;
    const DEFAULT_TIME = 0;
    const DEFAULT_TOTAL_TIME = 0;
    private ?int     $id        = null;
    private ?int     $projectId = null;
    private ?string  $type      = null;
    private ?string  $title     = null;
    private ?float   $time      = null;
    private ArrayCollection   $childs;
    private ?int     $parentId  = null;

    public static function getBuilder()
    {
        return new IssueEntityTestBuilder();
    }

    public static function getDefaultNew(): IssueEntity
    {
        return new IssueEntity();
    }

    public static function getDefaultTypeTopic(): IssueEntity
    {
        return new IssueEntity();
    }

    public function id(int $id)
    {
        $this->id = $id;

        return $this;
    }

    public function projectId(int $projectId)
    {
        $this->projectId = $projectId;

        return $this;
    }

    public function type(string $type)
    {
        $this->type = $type;

        return $this;
    }

    public function title(string $title)
    {
        $this->title = $title;

        return $this;
    }

    public function time(float $time)
    {
        $this->time = $time;

        return $this;
    }

    public function childs(ArrayCollection $childs)
    {
        $this->childs = $childs;

        return $this;
    }

    public function parentId(?int $parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    public function build()
    {
        $project = new IssueEntity();
        ($this->id) ? $project->setId($this->id) : null;
        ($this->time) ? $project->setTime($this->time) : null;
        ($this->childs) ? $project->setChilds($this->childs) : null;

        return $project;
    }
}