<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Teacher", inversedBy="project")
     * @ORM\JoinColumn(nullable=false)
     */
    private $teacher;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Group", mappedBy="project")
     */
    private $groups;

    /**
     * @ORM\Column(type="integer", length=11)
     */
    private $studentsPerGroup;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param mixed $teacher
     */
    public function setTeacher($teacher): void
    {
        $this->teacher = $teacher;
    }

    /**
     * @return Collection
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    /**
     * @param mixed $studentsPerGroup
     */
    public function setStudentsPerGroup($studentsPerGroup): void
    {
        $this->studentsPerGroup = $studentsPerGroup;
    }

    /**
     * @return mixed
     */
    public function getStudentsPerGroup()
    {
        return $this->studentsPerGroup;
    }

    /**
     * @param Group $group
     */
    public function addGroup(Group $group) {
        $this->groups->add($group);
    }

    /**
     * @param ArrayCollection $groups
     */
    public function setGroups(ArrayCollection $groups): void
    {
        $this->groups = $groups;
    }
}
