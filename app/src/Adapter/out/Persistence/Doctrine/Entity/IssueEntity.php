<?php

namespace App\Adapter\out\Persistence\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;


/**
 * @ORM\Entity(repositoryClass="App\Adapter\out\Persistence\Doctrine\Repository\IssueEntityRepository", repositoryClass=IssueEntityRepository::class)
 * @ORM\Table(name="issue")
 */
class IssueEntity
{



    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;
    /**
     * @ORM\Column(type="integer", length=255, unique=true, nullable=false)
     */
    protected int $projectId;
    /**
     * @ORM\Column(type="string", unique=false, nullable=true)
     */
    protected string $type;
    /**
     * @ORM\Column(type="string", unique=false, nullable=true)
     */
    protected string $title;
    /**
     * @ORM\Column(type="float", unique=false, nullable=true)
     */
    protected float $time;
    /**
     * @ORM\Column(type="float", unique=false, nullable=true)
     */
    protected float $totalTime;
    /**
     * @OneToMany(targetEntity="IssueEntity", mappedBy="parent")
     */
    protected ArrayCollection $childs;

    /**
     * @ManyToOne(targetEntity="IssueEntity", inversedBy="childs")
     * @JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private ?int $parent;
    // ...

    public function __construct() {
        $this->childs = new ArrayCollection();
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
     * @return IssueEntity
     */
    public function setId(?int $id): IssueEntity
    {
        $this->id = $id;

        return $this;
    }



    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->projectId;
    }

    /**
     * @param int $projectId
     *
     * @return IssueEntity
     */
    public function setProjectId(int $projectId): IssueEntity
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
     * @param string $type
     *
     * @return IssueEntity
     */
    public function setType(string $type): IssueEntity
    {
        $this->type = $type;

        return $this;
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
     * @return IssueEntity
     */
    public function setTitle(string $title): IssueEntity
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
     * @return IssueEntity
     */
    public function setTime(float $time): IssueEntity
    {
        $this->time = $time;

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
     * @param float $totalTime
     *
     * @return IssueEntity
     */
    public function setTotalTime(float $totalTime): IssueEntity
    {
        $this->totalTime = $totalTime;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getChilds(): ArrayCollection
    {
        return $this->childs;
    }

    /**
     * @param ArrayCollection $childs
     *
     * @return IssueEntity
     */
    public function setChilds(ArrayCollection $childs): IssueEntity
    {
        $this->childs = $childs;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getParent(): ?int
    {
        return $this->parent;
    }

    /**
     * @param int|null $parent
     *
     * @return IssueEntity
     */
    public function setParent(?int $parent): IssueEntity
    {
        $this->parent = $parent;

        return $this;
    }







}
