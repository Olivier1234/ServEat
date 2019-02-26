<?php

namespace App\DataFixtures;
use App\Entity\User;
use App\Entity\Notation;
use App\Entity\Meal;
use App\Entity\Booking;
use App\Entity\Message;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;
use Faker\Provider\Base;


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

            //////////////////////////////////////USERS/////////////////////////////////////
            $user = new User();
            $user->setEmail("ludovic.lecurieux@gmail.com");
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setPhone($faker->phoneNumber);
            $user->setGender("M");
            $user->setPseudo($faker->userName);
            $user->setDescription($faker->text);
            $password = "654321qwerty";
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user->setRoles(['ROLE_ADMIN']);
            $user->setImgpath("images/avatar/ludovic.lecurieux.jpg");
            $manager->persist($user);

            $user2 = new User();
            $user2->setEmail("user2@gmail.com");
            $firstname = $faker->firstName;
            $user2->setFirstName($firstname);
            $lastName = $faker->lastName;
            $user2->setLastName($lastName);
            $user2->setPhone($faker->phoneNumber);
            $user2->setGender("M");
            $user2->setPseudo($faker->userName);
            $user2->setDescription($faker->text);
            $password = "654321qwerty";
            $user2->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user2->setRoles(['ROLE_ADMIN']);
            $user2->setImgpath("images/avatar/user2.jpg");
            $manager->persist($user2);

            $user3 = new User();
            $user3->setEmail("user3@gmail.com");
            $firstname = $faker->firstName;
            $user3->setFirstName($firstname);
            $lastName = $faker->lastName;
            $user3->setLastName($lastName);
            $user3->setPhone($faker->phoneNumber);
            $user3->setGender("M");
            $user3->setPseudo($faker->userName);
            $user3->setDescription($faker->text);
            $password = "654321qwerty";
            $user3->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user3->setRoles(['ROLE_ADMIN']);
            $user3->setImgpath("images/avatar/user3.jpg");
            $manager->persist($user3);

        // create 20 products! Bam!
        /*for ($i = 0; $i < 5; $i++) {
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
        }*/

        //////////////////////////////////////MEALS/////////////////////////////////////
        $meal = new Meal();
        $meal->setTitle($faker->text);
        $meal->setDescription($faker->text);
        $meal->setPrice(4);
        $date = date_create_from_format('j-M-Y', '15-Feb-2009');
        $meal->setDateMeal($date);
        $meal->setMaxTraveller(4);
        $manager->persist($meal);

        //$meal->setType($faker->text);
        //$meal->setPicture($faker->text);
        //$meal->setAdress($faker->text);
        //$meal->setBooking($faker->text);
        //$meal->setNotation($faker->text);
        //$meal->setHost($faker->text);

        //////////////////////////////////////NOTATIONS/////////////////////////////////////
        for ($i = 0; $i < 7; $i++) {
            $notation = new Notation();
            $notation->setRating(4);
            $notation->setComment($faker->text);
            $notation->setMeal($meal);
            if($i % 3 == 0 ){
              $notation->setGiver($user2);}else{$notation->setGiver($user3);
            }
            $notation->setReceiver($user);
            $notation->setIsAnonymous(0);
            $notation->setIsVisible(0);
            $manager->persist($notation);
         }


        //////////////////////////////////////BOOKINGS/////////////////////////////////////
        $booking = new Booking();
        $booking->setIsPayed(0);
        $booking->setMeal($meal);
        $booking->setTraveler($user);
        $booking->setIsAccepted(0);
        $manager->persist($booking);
        $manager->flush();

         //////////////////////////////////////BOOKINGS/////////////////////////////////////


         $message = new Message();
         $message->setContent($faker->text);
         $message->setStatus("envoyé");
         $message->setCreatedAt(date_create_from_format('j-M-Y', '15-Feb-2009'));
         $message->setSender($user);
         $message->setReceiver($user2);
         $manager->persist($message);
         $manager->flush();

         $message = new Message();
         $message->setContent($faker->text);
         $message->setStatus("envoyé");
         $message->setCreatedAt(date_create_from_format('j-M-Y', '16-Feb-2009'));
         $message->setSender($user);
         $message->setReceiver($user2);
         $manager->persist($message);
         $manager->flush();

         $message = new Message();
         $message->setContent($faker->text);
         $message->setStatus("envoyé");
         $message->setCreatedAt(date_create_from_format('j-M-Y', '19-Feb-2009'));
         $message->setSender($user3);
         $message->setReceiver($user);
         $manager->persist($message);
         $manager->flush();

    }

}
