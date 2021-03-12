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
     * @ORM\OneToMany(targetEntity="App\Entity\Student", mappedBy="project")
     */
    private $students;

    /**
     * @ORM\Column(type="integer", length=11)
     */
    private $studentsPerGroup;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
        $this->students = new ArrayCollection();
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
     * @param $teacher
     * @return $this
     */
    public function setTeacher($teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    /**
     * @param $studentsPerGroup
     * @return $this
     */
    public function setStudentsPerGroup($studentsPerGroup): self
    {
        $this->studentsPerGroup = $studentsPerGroup;

        return $this;
    }

    /**
     * @return int
     */
    public function getStudentsPerGroup(): int
    {
        return $this->studentsPerGroup;
    }

    /**
     * @param Group $group
     */
    public function addGroup(Group $group): void
    {
        $this->groups->add($group);
    }

    /**
     * @param ArrayCollection $groups
     * @return $this
     */
    public function setGroups(ArrayCollection $groups): self
    {
        $this->groups = $groups;

        return $this;
    }

    /**
     * @return Teacher
     */
    public function getTeacher(): Teacher
    {
        return $this->teacher;
    }

    /**
     * @return Collection
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    /**
     * @param ArrayCollection $students
     * @return $this
     */
    public function setStudents(ArrayCollection $students): self
    {
        $this->students = $students;

        return $this;
    }
}
