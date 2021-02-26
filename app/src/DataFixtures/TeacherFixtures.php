<?php

namespace App\DataFixtures;

use App\Entity\Teacher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TeacherFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $teacher = new Teacher();
        $teacher->setUsername('teacher');
        $teacher->setPassword('kazkas');
        $manager->persist($teacher);
        $manager->flush();

        $this->addReference(self::TEACHER_REFERENCE, $teacher);
    }
}