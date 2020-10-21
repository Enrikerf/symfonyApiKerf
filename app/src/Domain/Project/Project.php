<?php

namespace App\Domain\Project;

class Project
{
    private ?int    $id;
    private string  $name;
    private int     $issueCount;

    public function __construct($name)
    {
        $this->setId(null);
        $this->setName($name);
        $this->setIssueCount(0);
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
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getIssueCount(): int
    {
        return $this->issueCount;
    }

    /**
     * @param int $issueCount
     */
    public function setIssueCount(int $issueCount): void
    {
        $this->issueCount = $issueCount;
    }
}