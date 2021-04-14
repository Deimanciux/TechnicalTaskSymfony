<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupRepository::class)
 * @ORM\Table(name="`group`")
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="groups")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Student", mappedBy="group")
     */
    private $students;

    public function __construct()
    {
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
     * @param $project
     * @return $this
     */
    public function setProject($project): self
    {
        $this->project = $project;

        return $this;
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

    /**
     * @return Project
     */
    public function getProject(): Project
    {
        return $this->project;
    }

    /**
     * @param Student $student
     * @return $this
     */
    public function addStudent(Student $student)
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);

            $student->setGroup($this);
        }

        return $this;
    }

    public function removeStudent(Student $student)
    {
        if ($this->students->contains($student)) {
            $this->students->removeElement($student);

            $student->setGroup(null);
        }

        return $this;
    }
}
