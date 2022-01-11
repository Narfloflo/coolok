<?php
namespace App\Service;
use App\Entity\User;

class UserService {
    
    public function calculAge(User $user)
    {
        $birthday = $user->getBirthday()->getTimestamp();
        $userAge = round((time() - $birthday) / 31556952);
        return $userAge;
    }

    public function calculAges($users){
        $usersAge = [];
        for($i = 0; $i < count($users); $i++){
            $birthday = $users[$i]->getBirthday()->getTimestamp();
            $userAge = round((time() - $birthday) / 31556952);
            $usersAge[] = $userAge;
        }
        return $usersAge;
    }
}