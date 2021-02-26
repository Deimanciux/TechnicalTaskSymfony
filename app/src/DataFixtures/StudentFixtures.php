<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StudentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $student = new Student();
        $student->setFullName("Ponas ponaitis");
        $student->setGroup($this->getReference(GroupFixtures::GROUP_REFERENCE));
        $manager->persist($student);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
          GroupFixtures::class
        ];
    }
}
