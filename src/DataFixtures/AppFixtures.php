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
            $user->setFirstName("Ludovic");
            $user->setLastName("Le Curieux");
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
            $user2->setFirstName("Louis");
            $user2->setLastName("Faraldo");
            $user2->setPhone($faker->phoneNumber);
            $user2->setGender("M");
            $user2->setPseudo($faker->userName);
            $user2->setDescription($faker->text);
            $password = "654321qwerty";
            $user2->setPassword($this->passwordEncoder->encodePassword($user2, $password));
            $user2->setRoles(['ROLE_ADMIN']);
            $user2->setImgpath("images/avatar/user2.jpg");
            $manager->persist($user2);

            $user3 = new User();
            $user3->setEmail("user3@gmail.com");
            $user3->setFirstName("Mathilde");
            $user3->setLastName("Raphi");
            $user3->setPhone($faker->phoneNumber);
            $user3->setGender("F");
            $user3->setPseudo($faker->userName);
            $user3->setDescription($faker->text);
            $password = "654321qwerty";
            $user3->setPassword($this->passwordEncoder->encodePassword($user3, $password));
            $user3->setRoles(['ROLE_ADMIN']);
            $user3->setImgpath("images/avatar/user3.jpg");
            $manager->persist($user3);

        // create 20 products! Bam!
        for ($i = 4; $i < 8; $i++) {
          $otherUser = new User();
          $otherUser->setEmail("user".$i."@gmail.com");
          $otherUser->setFirstName($faker->firstname);
          $otherUser->setLastName($faker->lastname);
          $otherUser->setPhone($faker->phoneNumber);
          $otherUser->setGender("F");
          $otherUser->setPseudo($faker->userName);
          $otherUser->setDescription($faker->text);
          $password = "654321qwerty";
          $otherUser->setPassword($this->passwordEncoder->encodePassword($otherUser, $password));
          $otherUser->setRoles(['ROLE_USER']);
          $otherUser->setImgpath("images/avatar/"."user".$i.".jpg");
          $manager->persist($otherUser);

        }

        //////////////////////////////////////MEALS/////////////////////////////////////
        //$user(ludovic lecurieux) cree un repas
        $meal = new Meal();
        $meal->setTitle("Délicieuse cuisine maison");
        $meal->setDescription($faker->text);
        $meal->setPrice(4);
        $date = date_create_from_format('j-M-Y', '15-Feb-2009');
        $meal->setDateMeal($date);
        $meal->setMaxTraveller(4);
        $manager->persist($meal);

        $meal2 = new Meal();
        $meal2->setTitle("Un autre repas");
        $meal2->setDescription($faker->text);
        $meal2->setPrice(4);
        $date = date_create_from_format('j-M-Y', '15-Feb-2009');
        $meal2->setDateMeal($date);
        $meal2->setMaxTraveller(4);
        $meal2->setHost($user2);

        $manager->persist($meal2);

        //$meal->setType($faker->text);
        //$meal->setPicture($faker->text);
        //$meal->setAdress($faker->text);
        //$meal->setBooking($faker->text);
        //$meal->setNotation($faker->text);
        $meal->setHost($user);

        //////////////////////////////////////BOOKINGS/////////////////////////////////////
        //user2 reserve un repas chez $user(ludovic)
        $booking = new Booking();
        $booking->setIsPayed(0);
        $booking->setMeal($meal);
        $booking->setTraveler($user2);
        $booking->setIsAccepted(0);
        $manager->persist($booking);

        //////////////////////////////////////MESSAGES/////////////////////////////////////
        $message = new Message();
        $message->setContent($faker->text);
        $message->setStatus("fsgdfsd");
        $date = date_create_from_format('j-M-Y', '15-Feb-2009');
        $message->setCreatedAt($date);
        $message->setSender($user2);
        $message->setReceiver($user);
        $manager->persist($message);

        $message2 = new Message();
        $message2->setContent($faker->text);
        $message2->setStatus("qwerty");
        $date = date_create_from_format('j-M-Y', '15-Feb-2009');
        $message2->setCreatedAt($date);
        $message2->setSender($user);
        $message2->getReceiver($user2);
        $manager->persist($message2);

        //////////////////////////////////////NOTATIONS/////////////////////////////////////
        //$user2 et $user3 note le repas de $user
        for ($i = 0; $i < 7; $i++) {
            $notation = new Notation();
            $notation->setRating(rand(1,5));
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




        $manager->flush();

         //////////////////////////////////////BOOKINGS/////////////////////////////////////

         // User : Ludovic
         // User2, User3 : fakes
         // avec User2, 3 messages dont un reçu et 2 envoyés
         // Avec User3, 2 messages, un reçu et un envoyé

         $message = new Message();
         $message->setContent($faker->text);
         $message->setStatus("envoyé");
         $message->setCreatedAt(date_create_from_format('j-M-Y h:m', '15-Feb-2009 9:43'));
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
         $message->setCreatedAt(date_create_from_format('j-M-Y h:m', '15-Feb-2009 10:54'));
         $message->setSender($user2);
         $message->setReceiver($user);
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

         $message = new Message();
         $message->setContent($faker->text);
         $message->setStatus("envoyé");
         $message->setCreatedAt(date_create_from_format('j-M-Y', '29-Feb-2009'));
         $message->setSender($user);
         $message->setReceiver($user3);
         $manager->persist($message);
         $manager->flush();

    }

}
