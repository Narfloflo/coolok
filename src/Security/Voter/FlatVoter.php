<?php

namespace App\Security\Voter;

use App\Entity\Flat;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class FlatVoter extends Voter
{
    const EDITING = 'flat_edit';

    private $security;

    public function __construct(Security $security){
        $this->security = $security;
    }

    // protected function supports(string $attribute, $subject): bool
    // {
    //     return in_array($attribute, [self::FLAT_EDIT])
    //         && $subject instanceof \App\Entity\Flat;
    // }

    // protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    // {
    //     $user = $token->getUser();
    //     // if the user is anonymous, do not grant access
    //     if (!$user instanceof UserInterface) {
    //         return false;
    //     }

    //     if($this->security->isGranted('ROLE_ADMIN')) return true;

    //     if(null === $subject->getUser()) return false;

    //     switch ($attribute) {
    //         case self::FLAT_EDIT :
    //             return $this->editable($flats, $user);
    //             break;
    //     }

    //     return false;
    // }

    // private function editable(Flat $flats, Users $user){
    //     if($this->security->isGranted("ROLE_EDITOR")) return true;
    //     return false;
    // }

    protected function supports(string $attribute, $subject): bool
    {
        if(!in_array($attribute, [self::EDITING])){
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if(!$user instanceof UserInterface){
            return false;
        }

        if($subject instanceof Flat){
            if($subject->getOwner() === $user){
                return true;
            }

            if($this->security->isGranted('ROLE_ADMIN')){
                return true;
            }
        }else{
            if($this->security->isGranted('ROLE_ORGANIZER')){
                return true;
            }
        }

        return false;
    }
}
