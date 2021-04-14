<?php

namespace App\DataFixtures;

use App\Entity\Group;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GroupFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $group = new Group();
        $group->setTitle('group');
        $group->setProject($this->getReference(ProjectFixtures::PROJECT_REFERENCE));
        $manager->persist($group);
        $manager->flush();

        $this->addReference(self::GROUP_REFERENCE, $group);
    }

    public function getDependencies()
    {
        return [
          ProjectFixtures::class
        ];
    }
}
