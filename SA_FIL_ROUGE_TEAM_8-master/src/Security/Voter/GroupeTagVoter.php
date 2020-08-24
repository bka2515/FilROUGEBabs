<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class GroupeTagVoter extends Voter
{
    protected function supports($attribute, $subject)
    {

        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['ALL'])
            && $subject instanceof \App\Entity\GroupeTag;

    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {

            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'ALL':
               return $user->getRole()=="ROLE_ADMIN" ||  $user->getRole()=="ROLE_FORMATEUR";
                break;

        }

        return false;
    }
}
