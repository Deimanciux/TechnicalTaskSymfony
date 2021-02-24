<?php

namespace App\Entity;

use App\Repository\GroupRepository;
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
     * @ORM\Column(type="integer", length=11)
     */
    private $maxAmountOfStudents;

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
     * @return int
     */
    public function getMaxAmountOfStudents()
    {
        return $this->maxAmountOfStudents;
    }

    /**
     * @param int $maxAmountOfStudents
     * @return $this
     */
    public function setMaxAmountOfStudents(int $maxAmountOfStudents): self
    {
        $this->maxAmountOfStudents = $maxAmountOfStudents;

        return $this;
    }
}
