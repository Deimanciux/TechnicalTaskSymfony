<?php

namespace App\Service;

use App\Entity\Group;
use App\Entity\Project;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class ProjectService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $amountOfGroups
     * @param Project $project
     * @throws \Doctrine\ORM\ORMException
     */
    public function assignGroupsToProject(int $amountOfGroups, Project $project): void
    {
        for ($i = 1; $i < $amountOfGroups + 1; $i++) {
            $group = new Group();
            $group->setTitle("Group #" . $i);
            $group->setProject($project);
            $project->addGroup($group);
            $this->entityManager->persist($group);
        }
    }
}