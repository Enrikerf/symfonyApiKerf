<?php

namespace App\Tests\Unitary\Domain\Issue;

use App\Domain\Issue\Issue;
use function PHPUnit\Framework\returnCallback;


class IssueTestBuilder
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
    const DEFAULT_CHILDS = [];
    const NOT_DEFAULT_TITLE = 'NOT_DEFAULT_TITLE';
    const NOT_DEFAULT_TIME = 100;
    private ?int     $id        = null;
    private ?int     $projectId = null;
    private ?string  $type      = null;
    private ?string  $title     = null;
    private ?float   $time      = null;
    private ?array   $childs    = null;
    private ?int     $parentId  = null;

    public static function getBuilder()
    {
        return new IssueTestBuilder();
    }

    public static function getDefaultNew(): Issue
    {
        return new Issue(
            self::DEFAULT_PROJECT_ID,
            self::DEFAULT_TITLE,
            self::DEFAULT_TYPE,
            self::DEFAULT_PARENT_ID
        );
    }

    public static function getDefaultTypeTopic(): Issue
    {
        return (new Issue(
            self::DEFAULT_PROJECT_ID,
            self::DEFAULT_TITLE,
            Issue::TYPE_TOPIC,
            self::DEFAULT_PARENT_ID
        ))->setChilds([
            self::getDefaultNew(),
            self::getDefaultNew(),
        ]);
    }

    public static function getDefaultPersisted(): Issue
    {
        return (new Issue(
            self::DEFAULT_PROJECT_ID,
            self::DEFAULT_TITLE,
            Issue::TYPE_TOPIC,
            self::DEFAULT_PARENT_ID
        ))->setChilds([
            self::getDefaultNew(),
            self::getDefaultNew(),
        ]);
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

    public function childs(array $childs)
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
        $project = new Issue($this->projectId, $this->title, $this->type, $this->parentId);
        ($this->id) ? $project->setId($this->id) : null;
        ($this->time) ? $project->setTime($this->time) : null;
        ($this->childs) ? $project->setChilds($this->childs) : null;

        return $project;
    }
}