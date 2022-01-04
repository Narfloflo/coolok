<?php

namespace App\DataFixtures;

use App\Entity\Flat;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i < 3; $i++){
            $user = new User();
            $user->setFirstname('John');
            $user->setLastname('Doe' . $i);
            $user->setEmail('johndoe'. $i .'@gmail.com');
            $user->setPassword('123');
            $user->setGender('men');
            $user->setCity('Lille');
            $user->setDescription('Bonjour je suis John, j\'habite à Lille et je cherche une colocation pour mes études. J\'aime les cacahuètes et symfony me saoule quand ça fonctionne pas ! Allez viens on est bien !');
            $user->setPassions('Football, Cacahuète, Frites, Bières');
            $user->setOptionSearch('both');
            $user->setOptionGender('all');
            $user->setOptionAgeMin(18);
            $user->setOptionAgeMax(30);
            $user->setOptionRentMin(250);
            $user->setOptionRentMax(500);
            $user->setPicture('https://t3.ftcdn.net/jpg/01/97/11/64/240_F_197116416_hpfTtXSoJMvMqU99n6hGP4xX0ejYa4M7.jpg');

            
            $flat = new Flat();
            $flat->setType('Appartement');
            $flat->setFurnished('yes');
            $flat->setOwner($user);
            $flat->setCity('Lomme');
            $flat->setSurface(100 + $i);
            $flat->setRooms(8);
            $flat->setFreeSpace(2);
            $flat->setTotalSpace(5);
            $flat->setRent(400);
            $flat->setDescription('Appartement plein sud, très spacieux, proche commerce. Gardien. Bail solidaire. Pas de garage.');
            $flat->setGender('all');
            $flat->setAvailable(true);
            $flat->setImages([
                'https://t4.ftcdn.net/jpg/02/35/84/73/240_F_235847393_7VOV7sNMBKiCNR4gltw9LLEKG4hgioYg.jpg',
                'https://t4.ftcdn.net/jpg/02/35/84/73/240_F_235847393_7VOV7sNMBKiCNR4gltw9LLEKG4hgioYg.jpg',
                'https://t4.ftcdn.net/jpg/02/69/08/59/240_F_269085933_H2v68xVPmnC5CczyZcuW4cTwX3V7iUAp.jpg']);

            $manager->persist($user);
            $manager->persist($flat);
        }

        $manager->flush();
    }
}
