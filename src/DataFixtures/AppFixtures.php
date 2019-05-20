<?php

namespace App\DataFixtures;
use App\Entity\User;
use App\Entity\Notation;
use App\Entity\Meal;
use App\Entity\Booking;
use App\Entity\Address;
use App\Entity\Message;

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

            //////////////////////////////////////USERS/////////////////////////////////////
            $user1 = new User();
            $user1->setEmail("ludovic.lecurieux@gmail.com");
            $user1->setFirstName("Ludovic");
            $user1->setLastName("Le Curieux");
            $user1->setPhone($faker->phoneNumber);
            $user1->setGender(false);
            $user1->setPseudo($faker->userName);
            $user1->setDescription($faker->text);
            $password = "654321qwerty";
            $user1->setPassword($this->passwordEncoder->encodePassword($user1, $password));
            $user1->setRoles(['ROLE_ADMIN']);
            $user1->setAvatar("/images/avatar/ludovic.lecurieux.jpg");
            $manager->persist($user1);

            $user2 = new User();
            $user2->setEmail("leyla.lenoan@outlook.fr");
            $user2->setFirstName("Leyla");
            $user2->setLastName("LE NOAN");
            $user2->setPhone($faker->phoneNumber);
            $user2->setGender(true);
            $user2->setPseudo("LeylaLN");
            $user2->setDescription($faker->text);
            $password = "azerty";
            $user2->setPassword($this->passwordEncoder->encodePassword($user2, $password));
            $user2->setRoles(['ROLE_ADMIN']);
            $user2->setAvatar("/images/avatar/leyla-lenoan.jpg");
            $manager->persist($user2);

            $user3 = new User();
            $user3->setEmail("user3@gmail.com");
            $firstname = $faker->firstName;
            $user3->setFirstName($firstname);
            $lastName = $faker->lastName;
            $user3->setLastName($lastName);
            $user3->setPhone($faker->phoneNumber);
            $user3->setGender(true);
            $user3->setPseudo($faker->userName);
            $user3->setDescription($faker->text);
            $password = "654321qwerty";
            $user3->setPassword($this->passwordEncoder->encodePassword($user3, $password));
            $user3->setRoles(['ROLE_ADMIN']);
            $user3->setAvatar("/images/avatar/user3.jpg");
            $manager->persist($user3);

        // create 20 products! Bam!
        for ($i = 4; $i < 8; $i++) {
          $otherUser = new User();
          $otherUser->setEmail("user".$i."@gmail.com");
          $otherUser->setFirstName($faker->firstname);
          $otherUser->setLastName($faker->lastname);
          $otherUser->setPhone($faker->phoneNumber);
          $otherUser->setGender($faker->boolean);
          $otherUser->setPseudo($faker->userName);
          $otherUser->setDescription($faker->text);
          $password = "654321qwerty";
          $otherUser->setPassword($this->passwordEncoder->encodePassword($otherUser, $password));
          $otherUser->setRoles(['ROLE_USER']);
          $otherUser->setAvatar("/images/avatar/"."user".$i.".jpg");
          $manager->persist($otherUser);

        }

        //////////////////////////////////////ADDRESSES/////////////////////////////////////
        // user1 possede une addresse
        $address1 = new Address();
        $address1->setStreet("1 rue de Paris");
        $address1->setZc("75000");
        $address1->setCity("Paris");
        $address1->setCountry("France");
        $address1->setIsDefault(true);
        $address1->setHost($user1);
        $manager->persist($address1);

        // user2 possede une addresse
        $address2 = new Address();
        $address2->setStreet("1 rue de Berlin");
        $address2->setZc("23000");
        $address2->setCity("Berlin");
        $address2->setCountry("Allemagne");
        $address2->setIsDefault(true);
        $address2->setHost($user2);
        $manager->persist($address2);

        // user3 possede une addresse
        $address3 = new Address();
        $address3->setStreet("1 rue de Madrid");
        $address3->setZc("46000");
        $address3->setCity("Madrid");
        $address3->setCountry("Espagne");
        $address3->setIsDefault(false);
        $address3->setHost($user3);
        $manager->persist($address3);

        //////////////////////////////////////MEALS/////////////////////////////////////
        //user1 cree un repas
        $meal1 = new Meal();
        $meal1->setTitle("Un premier repas");
        $meal1->setDescription($faker->text);
        $meal1->setPrice(6);
        $date = date_create_from_format('j-M-Y', '15-Feb-2009');
        $meal1->setDateMeal($date);
        $meal1->setMaxTraveller(4);
        $meal1->setHost($user1);
        $meal1->setAddress($address1);
        $manager->persist($meal1);

        //user2 cree un repas
        $meal2 = new Meal();
        $meal2->setTitle("Un autre repas");
        $meal2->setDescription($faker->text);
        $meal2->setPrice(4);
        $date = date_create_from_format('j-M-Y', '15-Feb-2009');
        $meal2->setDateMeal($date);
        $meal2->setMaxTraveller(3);
        $meal2->setHost($user2);
        $meal2->setAddress($address2);
        $manager->persist($meal2);

        //////////////////////////////////////BOOKINGS/////////////////////////////////////
        //user2 reserve un repas chez $user1
        $booking1 = new Booking();
        $booking1->setIsPayed(false);
        $booking1->setMeal($meal1);
        $booking1->setTraveler($user2);
        $booking1->setIsAccepted(false);
        $manager->persist($booking1);

        //user3 reserve un repas chez $user1
        $booking2 = new Booking();
        $booking2->setIsPayed(false);
        $booking2->setMeal($meal1);
        $booking2->setTraveler($user3);
        $booking2->setIsAccepted(true);
        $manager->persist($booking2);

        //////////////////////////////////////MESSAGES/////////////////////////////////////
        $message1 = new Message();
        $message1->setContent($faker->text);
        $message1->setStatus("fsgdfsd");
        $date = date_create_from_format('j-M-Y', '15-Feb-2009');
        $message1->setCreatedAt($date);
        $message1->setSender($user2);
        $message1->setReceiver($user1);
        $manager->persist($message1);

        $message2 = new Message();
        $message2->setContent($faker->text);
        $message2->setStatus("qwerty");
        $date = date_create_from_format('j-M-Y', '15-Feb-2009');
        $message2->setCreatedAt($date);
        $message2->setSender($user1);
        $message2->setReceiver($user2);
        $manager->persist($message2);

        //////////////////////////////////////NOTATIONS/////////////////////////////////////
        for ($i = 0; $i < 7; $i++) {
            $notation = new Notation();
            $notation->setRating(4);
            $notation->setComment($faker->text);
            $notation->setMeal($meal1);
            if($i % 3 == 0 ){
              $notation->setGiver($user2);}else{$notation->setGiver($user3);
            }
            $notation->setReceiver($user1);
            $notation->setIsAnonymous(false);
            $notation->setIsVisible(false);
            $manager->persist($notation);
         }

         //////////////////////////////////////MESSAGES/////////////////////////////////////
         $message = new Message();
         $message->setContent($faker->text);
         $message->setStatus("envoyé");
         $message->setCreatedAt(date_create_from_format('j-M-Y h:m', '15-Feb-2009 9:43'));
         $message->setSender($user1);
         $message->setReceiver($user2);
         $manager->persist($message);
         $manager->flush();

         $message = new Message();
         $message->setContent($faker->text);
         $message->setStatus("envoyé");
         $message->setCreatedAt(date_create_from_format('j-M-Y', '16-Feb-2009'));
         $message->setSender($user1);
         $message->setReceiver($user2);
         $manager->persist($message);
         $manager->flush();

         $message = new Message();
         $message->setContent($faker->text);
         $message->setStatus("envoyé");
         $message->setCreatedAt(date_create_from_format('j-M-Y h:m', '15-Feb-2009 10:54'));
         $message->setSender($user2);
         $message->setReceiver($user1);
         $manager->persist($message);
         $manager->flush();

         $message = new Message();
         $message->setContent($faker->text);
         $message->setStatus("envoyé");
         $message->setCreatedAt(date_create_from_format('j-M-Y', '19-Feb-2009'));
         $message->setSender($user3);
         $message->setReceiver($user1);
         $manager->persist($message);
         $manager->flush();

         $message = new Message();
         $message->setContent($faker->text);
         $message->setStatus("envoyé");
         $message->setCreatedAt(date_create_from_format('j-M-Y', '29-Feb-2009'));
         $message->setSender($user1);
         $message->setReceiver($user3);
         $manager->persist($message);
         $manager->flush();
    }

}
