<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProjectFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $project = new Project();
        $project->setTitle('projektas');
        $project->setStudentsPerGroup(2);
        $project->setTeacher($this->getReference(TeacherFixtures::TEACHER_REFERENCE));
        $manager->persist($project);
        $manager->flush();

        $this->addReference(self::PROJECT_REFERENCE, $project);
    }

    public function getDependencies()
    {
        return [
          TeacherFixtures::class
        ];
    }
}