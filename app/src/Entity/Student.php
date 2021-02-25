<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 * @UniqueEntity(fields="fullName", message="This name is already used")
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=70, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(min="2", max="70")
     */
    private $fullName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Group", inversedBy="students")
     * @ORM\JoinColumn(nullable=false)
     */
    private $group;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param $fullName
     * @return $this
     */
    public function setFullName($fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     */
    public function setGroup($group): void
    {
        $this->group = $group;
    }
}
