<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;


class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder=$encoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker=Faker\Factory::create('fr_FR');
        $apprenant=new Profil();
        $apprenant->setLibelle('Apprenant');
        $formateur=new Profil();
        $formateur->setLibelle('Formateur');
        $admin=new Profil();
        $admin->setLibelle('Admin');
        $cm=new Profil();
        $cm->setLibelle('CM');
        $manager->persist($apprenant);
        $manager->persist($formateur);
        $manager->persist($admin);
        $manager->persist($cm);
        $manager->flush();

        $profils=[$apprenant, $formateur, $admin, $cm];
        for ($i = 0; $i < count($profils); $i++) {

            $profil=$profils[$i];
            for($j=0;$j<3;$j++){

                $user= new User();
               $user->setPrenom($faker->firstName());
                 $user->setNom($faker->lastName);
                $user->setEmail($faker->email);
                $user->setTelephone($faker->phoneNumber);
                $user->setLogin($faker->userName);
                $password = $this->encoder->encodePassword($user,'password');
                $user->setProfil($profil);
                $user->setPassword($password);
                $user->setGenre('Feminin');
                $user->setStatus('actif');
            // $user->setAvatar($faker->ava);
                 $user->setAdresse($faker->address);
                $manager->persist($user);
            }
        }

        $manager->flush();
    }
}
