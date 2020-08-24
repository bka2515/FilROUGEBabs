<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class DefaultVoter extends Voter
{
    protected function supports($attribute, $subject)
    {

        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['GET', 'GET_COMPETENCES','DELETE','POST','GET_ONE','GET_COMPETENCE','POST_GROUPE','PUT_GRPE'])
            && $subject instanceof \App\Entity\GroupeCompetences;
    }

    protected function voteOnAttribute($attribute, $groupeCompetences, TokenInterface $token)
    {

        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

       // if($groupeCompetences->getAdmin()==null){
       //     return false;
       // }
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'GET':
                return $user->getRole()=="ROLE_ADMIN" ||$user->getRole()=="ROLE_APPRENANT" || $user->getRole()=="ROLE_CM";
         //      return $groupeCompetences->getAdmin()->getId()== $user->getId();
                break;
            case 'GET_COMPETENCES':

                return $user->getRole()=="ROLE_ADMIN" ||$user->getRole()=="ROLE_APPRENANT" || $user->getRole()=="ROLE_CM";
                //      return $groupeCompetences->getAdmin()->getId()== $user->getId();
                break;
            case 'POST_GROUPE':
              //  return true;
                if($user->getRole()=="ROLE_ADMIN"){
                    $groupeCompetences->setAdmin($user);
                    return true;
                }
             //  return $user->getRole()=="ROLE_ADMIN";

                //  return $groupeCompetences->getAdmin()->getId()== $user->getId();

                break;

            case 'GET_ONE':
                return $user->getRole()=="ROLE_ADMIN" ||$user->getRole()=="ROLE_APPRENANT" || $user->getRole()=="ROLE_CM" || $user->getRole()=="ROLE_FORMATEUR";
                //      return $groupeCompetences->getAdmin()->getId()== $user->getId();
                break;
            case 'GET_COMPETENCE':
                return $user->getRole()=="ROLE_ADMIN" ||$user->getRole()=="ROLE_APPRENANT" || $user->getRole()=="ROLE_CM" || $user->getRole()=="ROLE_FORMATEUR";
                //      return $groupeCompetences->getAdmin()->getId()== $user->getId();
                break;
            case 'PUT_GRPE':
                return $user->getRole()=="ROLE_ADMIN" ||$user->getRole()=="ROLE_APPRENANT" || $user->getRole()=="ROLE_CM" || $user->getRole()=="ROLE_FORMATEUR";
                //      return $groupeCompetences->getAdmin()->getId()== $user->getId();
                break;


        }

        return false;
    }
}
