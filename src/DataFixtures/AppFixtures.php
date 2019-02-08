<?php

namespace App\DataFixtures;
use App\Entity\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;


class AppFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    
    public function load(ObjectManager $manager)
    {
         // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');
        
         $user = new User();
            $user->setEmail("ludovic.lecurieux3@gmail.com");
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setPhone($faker->phoneNumber);
            $user->setGender("M");
            $user->setPseudo($faker->userName);
            $user->setWebsite("www.google.com");
            $user->setDescription($faker->text);
            $password = "654321qwerty";
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user->setRoles(['ROLE_ADMIN']);
            $user->setImgpath("images/avatar/ludovic.lecurieux.jpg");
            $manager->persist($user);
        
        // create 20 products! Bam!
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setEmail($faker->freeEmail);
            $firstname = $faker->firstName;
            $user->setFirstName($firstname);
            $lastName = $faker->lastName;
            $user->setLastName($lastName);
            $user->setPhone($faker->phoneNumber);
            $user->setGender("M");
            $user->setPseudo($faker->userName);
            $user->setWebsite("www.google.com");
            $user->setDescription($faker->text);
            $password = "654321qwerty";
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user->setRoles(['ROLE_ADMIN']);
            $user->setImgpath("images/avatar/" . $firstname . "." . $lastName . ".jpg");
            $manager->persist($user);
        }

        $manager->flush();
    }
}