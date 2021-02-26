<?php

namespace App\Security;

use App\Entity\Project;
use App\Entity\Teacher;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ProjectVoter extends Voter
{
    const ADD = 'add';

    protected function supports(string $attribute, $subject)
    {
        if (!in_array($attribute, [self::ADD])) {
            return false;
        }

        if (!$subject instanceof Project) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $authenticatedUser = $token->getUser();

        if (!$authenticatedUser instanceof Teacher) {
            return false;
        }

        /**@var Project $project */
        $project = $subject;

        return $project->getTeacher()->getId() === $authenticatedUser->getId();
    }
}