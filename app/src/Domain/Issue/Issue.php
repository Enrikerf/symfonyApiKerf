<?php

namespace App\Domain\Issue;

class Issue
{

    public const   TYPE_TOPIC = 'topic';
    public const   TYPE_CONFIG = 'config';
    public const   TYPE_ACTION = 'action';
    public const   TYPE_DESIGN = 'design';
    public const   TYPE_DEV = 'dev';
    private ?int       $id;
    private int        $projectId;
    private ?int       $parent;
    private string     $type;
    private string     $title;
    private float      $time      = 0;
    private float      $totalTime = 0;
    private array      $childs;

    public function __construct(int $projectId, string $title, string $type, ?int $parent = null)
    {
        $this->setId(null);
        $this->setProjectId($projectId);
        $this->setTitle($title);
        $this->type = $type;
        $this->parent = $parent;
        $this->setChilds([]);
        $this->setTime(0);
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     *
     * @return Issue
     */
    public function setId(?int $id): Issue
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getProjectId(): ?int
    {
        return $this->projectId;
    }

    /**
     * @param int|null $projectId
     *
     * @return Issue
     */
    public function setProjectId(?int $projectId): Issue
    {
        $this->projectId = $projectId;

        return $this;
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
     * @param string $title
     *
     * @return Issue
     */
    public function setTitle(string $title): Issue
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return float
     */
    public function getTime(): float
    {
        return $this->time;
    }

    /**
     * @param float $time
     *
     * @return Issue
     */
    public function setTime(float $time): Issue
    {
        ($time < 0) ? $this->time = 0 : $this->time = $time;
        $this->calculateTotalTime();

        return $this;
    }

    /**
     * @return float
     */
    public function getTotalTime(): float
    {
        return $this->totalTime;
    }

    /**
     * @return array
     */
    public function getChilds(): array
    {
        return $this->childs;
    }

    /**
     * @param array $childs
     *
     * @return Issue|null
     */
    public function setChilds(array $childs): Issue
    {
        if ($this->type !== self::TYPE_TOPIC) {
            $this->childs = [];

            return $this;
        }
        $this->childs = $childs;
        $this->calculateTotalTime();

        return $this;
    }

    private function calculateTotalTime()
    {
        $this->totalTime = $this->time;
        foreach ($this->childs as $child) {
            $this->totalTime += $child->getTime();
        }
    }
}