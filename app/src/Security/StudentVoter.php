<?php

namespace App\Security;

use App\Entity\Student;
use App\Entity\Teacher;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class StudentVoter extends Voter
{
    const EDIT = 'edit';
    const DELETE = 'delete';
    const ADD = 'add';

    protected function supports(string $attribute, $subject)
    {
        if (!in_array($attribute, [self::EDIT, self::DELETE, self::ADD])) {
            return false;
        }

        if (!$subject instanceof Student) {
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

        /**@var Student $student */
        $student = $subject;

        return $student->getGroup()->getProject()->getTeacher()->getId() === $authenticatedUser->getId();
    }
}