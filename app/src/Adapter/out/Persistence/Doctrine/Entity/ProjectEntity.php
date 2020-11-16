<?php

namespace App\Adapter\out\Persistence\Doctrine\Entity;

use App\Adapter\out\Persistence\Doctrine\Repository;
use Doctrine\ORM\Mapping as ORM;
use ReflectionClass;


/**
 * @ORM\Entity(repositoryClass=ProjectEntityRepository::class)
 * @ORM\Table(name="project")
 */
class ProjectEntity
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     */
    private ?string $name = null;
    /**
     * @ORM\Column(type="integer", unique=false, nullable=false)
     */
    private ?int $issueCount = 0;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return ProjectEntity
     */
    public function setId($id): ProjectEntity
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     *
     * @return ProjectEntity
     */
    public function setName(?string $name): ProjectEntity
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getIssueCount(): ?int
    {
        return $this->issueCount;
    }

    /**
     * @param int|null $issueCount
     *
     * @return ProjectEntity
     */
    public function setIssueCount(?int $issueCount): ProjectEntity
    {
        $this->issueCount = $issueCount;

        return $this;
    }


}
