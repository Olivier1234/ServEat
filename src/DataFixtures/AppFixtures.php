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

    }

}
