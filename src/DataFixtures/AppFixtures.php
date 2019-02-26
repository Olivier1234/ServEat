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
            $user1 = new User();
            $user1->setEmail("ludovic.lecurieux@gmail.com");
            $user1->setFirstName("Ludovic");
            $user1->setLastName("Le Curieux");
            $user1->setPhone($faker->phoneNumber);
            $user1->setGender("M");
            $user1->setPseudo($faker->userName);
            $user1->setDescription($faker->text);
            $password = "654321qwerty";
            $user1->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user1->setRoles(['ROLE_ADMIN']);
            $user1->setImgpath("images/avatar/ludovic.lecurieux.jpg");
            $manager->persist($user);

            $user2 = new User();
            $user2->setEmail("leyla.lenoan@outlook.fr");
            $user2->setFirstName("Leyla");
            $user2->setLastName("LE NOAN");
            $user2->setPhone($faker->phoneNumber);
            $user2->setGender("F");
            $user2->setPseudo("LeylaLN");
            $user2->setDescription($faker->text);
            $password = "azerty";
            $user2->setPassword($this->passwordEncoder->encodePassword($user2, $password));
            $user2->setRoles(['ROLE_ADMIN']);
            $user2->setImgpath("images/avatar/leyla-lenoan.jpg");
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
        $meal->setHost($user2);
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
        $meal->setHost($user1);

        //////////////////////////////////////BOOKINGS/////////////////////////////////////
        //user2 reserve un repas chez $user1
        $booking = new Booking();
        $booking->setIsPayed(0);
        $booking->setMeal($meal);
        $booking->setTraveler($user2);
        $booking->setIsAccepted(0);
        $manager->persist($booking);

        //user3 reserve un repas chez $user1
        $booking = new Booking();
        $booking->setIsPayed(0);
        $booking->setMeal($meal);
        $booking->setTraveler($user3);
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
        $booking->setTraveler($user1);
        $booking->setIsAccepted(0);
        $manager->persist($booking);
        $manager->flush();

         //////////////////////////////////////MESSAGES/////////////////////////////////////
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
