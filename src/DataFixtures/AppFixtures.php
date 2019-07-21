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
        \Stripe\Stripe::setApiKey('sk_test_eVxSmneYt3p7j9FH32xajzmG');

            //////////////////////////////////////USERS/////////////////////////////////////
          
            $user1 = new User();
            $user1->setEmail("eric.pecheur@gmail.com");
            $user1->setFirstName("Eric");
            $user1->setLastName("Pecheur");
            $user1->setPhone($faker->phoneNumber);
            $user1->setGender(false);
            $user1->setPseudo("EricP");
            $user1->setDescription("kbjbljb ljkjk"
                                  );
            $password = "654321qwerty";
            $user1->setPassword($this->passwordEncoder->encodePassword($user1, $password));
            $user1->setRoles(['ROLE_ADMIN']);
            $user1->setAvatar("/images/avatars/EricP.jpg");

            $manager->persist($user1);

            // Create a Stripe Customer:
            if($user1->getCustomerPaymentId() == null)
            {
              $customer = \Stripe\Customer::create([
                'source' => 'tok_visa',
                'email' => $user1->getEmail(),
              ]);
              $user1->setCustomerPaymentId($customer->id);
  
            }
            

            $user2 = new User();
            $user2->setEmail("maryse.vanderhorn@outlook.fr");
            $user2->setFirstName("Maryse");
            $user2->setLastName("VANDERHORN");
            $user2->setPhone($faker->phoneNumber);
            $user2->setGender(true);
            $user2->setPseudo("MVand");
            $user2->setDescription($faker->text);
            $password = "azerty";
            $user2->setPassword($this->passwordEncoder->encodePassword($user2, $password));
            $user2->setRoles(['ROLE_ADMIN']);
            $user2->setAvatar("/images/avatars/MVan.png");
            $manager->persist($user2);

            // Create a Stripe Customer:
            if($user2->getCustomerPaymentId() == null)
            {
              $customer = \Stripe\Customer::create([
                'source' => 'tok_visa',
                'email' => $user2->getEmail(),
              ]);
              $user2->setCustomerPaymentId($customer->id);
  
            }
            
        for ($i = 4; $i < 8; $i++) {
          $otherUser = new User();
          $firstname = $faker->firstName;
          $lastname = $faker->lastName;
          $otherUser->setEmail("user".$i."@gmail.com");
          $otherUser->setFirstName($firstname);
          $otherUser->setLastName($lastname);
          $otherUser->setPhone($faker->phoneNumber);
          $otherUser->setGender($faker->boolean);
          $pseudo = substr($firstname,0,1);
          $otherUser->setPseudo($pseudo.$lastname);
          $otherUser->setDescription($faker->text);
          $password = "654321qwerty";
          $otherUser->setPassword($this->passwordEncoder->encodePassword($otherUser, $password));
          $otherUser->setRoles(['ROLE_USER']);
          $otherUser->setAvatar("/images/avatars/"."user".$i.".jpg");
          $manager->persist($otherUser);

            // other user possede une addresse
          $address = new Address();
          $address->setStreet($i*$i." rue Lafayette");
          $address->setZc("75000");
          $address->setCity("Paris");
          $address->setCountry("France");
          $address->setIsDefault(true);
          $address->setHost($otherUser);
          $manager->persist($address);

          if($i == 4)
          {
            $meal = new Meal();
            $meal->setTitle("FRENCH DINNER IN PARIS");
            $meal->setDescription('<p  style="color:black"><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">Casual and fun French Dinner in the center of Paris<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">• Savor a 3-course dinner with tasty French dishes and wine (e.g roasted camembert and quiches)<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">• 10-minutes walk from Notre Dame Cathedral<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">• Meet people from all around the world<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">• Vegan, vegetarian and gluten-free options are available upon request<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">About your host Philippe: <br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">“By day, I’m a Paris policeman. By night, I love to host guests from around the world at my table with Dzianis. We’re two guys who love cooking, traveling, and meeting new people. We would be delighted to welcome you into our flat right near Notre-Dame. Join us for a friendly and casual meal around the traditional French quiche.<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">Don’t hesitate to tell us your allergies and intolerances, we are very flexible with that. And we could satisfy you :-)<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">** Available sometimes at LUNCHTIME &amp; WEEKENDS for a minimum of 6 people and maximum 10 people **<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">** For PRIVATE EVENTS (minimum 8/10 people) we will offer a BOTTLE OF CHAMPAGNE! ???? **</bdi></p><div class="__menuDescription" style="text-align: center; line-height: 24px; letter-spacing: 1px; color: rgb(53, 53, 48); padding-bottom: 16px; font-family: circular, sans-serif;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">APÉRITIF</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">WELCOME DRINK</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">Chilled Rosé Served with our appetizers<br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; line-height: 24px; letter-spacing: 1px; color: rgb(53, 53, 48); padding-bottom: 16px; font-family: circular, sans-serif;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">STARTER</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">ROASTED CAMEMBERT</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">Served with different breads and fresh salad with tomatoes<br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; line-height: 24px; letter-spacing: 1px; color: rgb(53, 53, 48); padding-bottom: 16px; font-family: circular, sans-serif;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">MAIN COURSE</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">A TRADITIONAL FRENCH QUICHE</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">Homemade French quiches with a summer twist from my traditional recipe<br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; line-height: 24px; letter-spacing: 1px; color: rgb(53, 53, 48); padding-bottom: 16px; font-family: circular, sans-serif;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">DESSERT</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">A SURPRISE!</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">Seasonal dessert according to the chef\'s mood<br></bdi></p></div></div><p><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"></bdi></p><div class="__menuDescription" style="text-align: center; line-height: 24px; letter-spacing: 1px; color: rgb(53, 53, 48); padding-bottom: 16px; font-family: circular, sans-serif;"><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">BOISSONS</h5><p dir="auto" class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;">Vin, Apéritif</p></div><p><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi></p>');
            $meal->setPrice(4);
            $date = date_create_from_format('j-M-Y', '13-Jul-2019');
            $meal->setDateMeal($date);
            $meal->setMaxTraveller($i);
            $meal->setHost($otherUser);
            $meal->setAddress($address);
            $manager->persist($meal);
          }
          elseif($i == 5)
          {
            $meal = new Meal();
            $meal->setTitle("FRENCH DINNER IN PARIS");
            $meal->setDescription('<p  style="color:black"><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">Casual and fun French Dinner in the center of Paris<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">• Savor a 3-course dinner with tasty French dishes and wine (e.g roasted camembert and quiches)<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">• 10-minutes walk from Notre Dame Cathedral<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">• Meet people from all around the world<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">• Vegan, vegetarian and gluten-free options are available upon request<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">About your host Philippe: <br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">“By day, I’m a Paris policeman. By night, I love to host guests from around the world at my table with Dzianis. We’re two guys who love cooking, traveling, and meeting new people. We would be delighted to welcome you into our flat right near Notre-Dame. Join us for a friendly and casual meal around the traditional French quiche.<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">Don’t hesitate to tell us your allergies and intolerances, we are very flexible with that. And we could satisfy you :-)<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">** Available sometimes at LUNCHTIME &amp; WEEKENDS for a minimum of 6 people and maximum 10 people **<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">** For PRIVATE EVENTS (minimum 8/10 people) we will offer a BOTTLE OF CHAMPAGNE! ???? **</bdi></p><div class="__menuDescription" style="text-align: center; line-height: 24px; letter-spacing: 1px; color: rgb(53, 53, 48); padding-bottom: 16px; font-family: circular, sans-serif;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">APÉRITIF</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">WELCOME DRINK</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">Chilled Rosé Served with our appetizers<br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; line-height: 24px; letter-spacing: 1px; color: rgb(53, 53, 48); padding-bottom: 16px; font-family: circular, sans-serif;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">STARTER</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">ROASTED CAMEMBERT</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">Served with different breads and fresh salad with tomatoes<br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; line-height: 24px; letter-spacing: 1px; color: rgb(53, 53, 48); padding-bottom: 16px; font-family: circular, sans-serif;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">MAIN COURSE</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">A TRADITIONAL FRENCH QUICHE</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">Homemade French quiches with a summer twist from my traditional recipe<br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; line-height: 24px; letter-spacing: 1px; color: rgb(53, 53, 48); padding-bottom: 16px; font-family: circular, sans-serif;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">DESSERT</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">A SURPRISE!</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">Seasonal dessert according to the chef\'s mood<br></bdi></p></div></div><p><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"></bdi></p><div class="__menuDescription" style="text-align: center; line-height: 24px; letter-spacing: 1px; color: rgb(53, 53, 48); padding-bottom: 16px; font-family: circular, sans-serif;"><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">BOISSONS</h5><p dir="auto" class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;">Vin, Apéritif</p></div><p><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi></p>');
            $meal->setPrice(4);
            $date = date_create_from_format('j-M-Y', '25-Mar-2019');
            $meal->setDateMeal($date);
            $meal->setMaxTraveller($i);
            $meal->setHost($otherUser);
            $meal->setAddress($address);
            $manager->persist($meal);
          }
          elseif($i == 6)
          {

          }
          elseif($i == 7)
          {

          }
          $manager->flush();


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

        //////////////////////////////////////MEALS/////////////////////////////////////
        //user1 cree un repas
        $meal1 = new Meal();
        $meal1->setTitle("Mon repas");
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
        $meal2->setTitle("FRENCH DINNER IN PARIS");
        $meal2->setDescription('<p  style="color:black"><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">Casual and fun French Dinner in the center of Paris<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">• Savor a 3-course dinner with tasty French dishes and wine (e.g roasted camembert and quiches)<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">• 10-minutes walk from Notre Dame Cathedral<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">• Meet people from all around the world<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">• Vegan, vegetarian and gluten-free options are available upon request<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">About your host Philippe: <br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">“By day, I’m a Paris policeman. By night, I love to host guests from around the world at my table with Dzianis. We’re two guys who love cooking, traveling, and meeting new people. We would be delighted to welcome you into our flat right near Notre-Dame. Join us for a friendly and casual meal around the traditional French quiche.<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">Don’t hesitate to tell us your allergies and intolerances, we are very flexible with that. And we could satisfy you :-)<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">** Available sometimes at LUNCHTIME &amp; WEEKENDS for a minimum of 6 people and maximum 10 people **<br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;">** For PRIVATE EVENTS (minimum 8/10 people) we will offer a BOTTLE OF CHAMPAGNE! ???? **</bdi></p><div class="__menuDescription" style="text-align: center; line-height: 24px; letter-spacing: 1px; color: rgb(53, 53, 48); padding-bottom: 16px; font-family: circular, sans-serif;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">APÉRITIF</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">WELCOME DRINK</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">Chilled Rosé Served with our appetizers<br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; line-height: 24px; letter-spacing: 1px; color: rgb(53, 53, 48); padding-bottom: 16px; font-family: circular, sans-serif;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">STARTER</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">ROASTED CAMEMBERT</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">Served with different breads and fresh salad with tomatoes<br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; line-height: 24px; letter-spacing: 1px; color: rgb(53, 53, 48); padding-bottom: 16px; font-family: circular, sans-serif;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">MAIN COURSE</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">A TRADITIONAL FRENCH QUICHE</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">Homemade French quiches with a summer twist from my traditional recipe<br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; line-height: 24px; letter-spacing: 1px; color: rgb(53, 53, 48); padding-bottom: 16px; font-family: circular, sans-serif;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">DESSERT</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">A SURPRISE!</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">Seasonal dessert according to the chef\'s mood<br></bdi></p></div></div><p><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"></bdi></p><div class="__menuDescription" style="text-align: center; line-height: 24px; letter-spacing: 1px; color: rgb(53, 53, 48); padding-bottom: 16px; font-family: circular, sans-serif;"><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">BOISSONS</h5><p dir="auto" class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;">Vin, Apéritif</p></div><p><bdi dir="auto" style="color: rgb(53, 53, 48); font-family: circular, sans-serif; text-align: justify; white-space: pre-line; display: block;"><br></bdi></p>');
        $meal2->setPrice(4);
        $date = date_create_from_format('j-M-Y', '15-Feb-2009');
        $meal2->setDateMeal($date);
        $meal2->setMaxTraveller(3);
        $meal2->setHost($user2);
        $meal2->setAddress($address2);
        $manager->persist($meal2);

        //user2 cree un repas
        $meal3 = new Meal();
        $meal3->setTitle("A FESTIVE DINNER PARTY NEAR THE BUTTES CHAUMONT");
        $meal3->setDescription('<p style="color:black"><bdi dir="auto" style="text-align: justify; display: block;"><bdi dir="auto" style="display: block;"><bdi dir="auto" style="display: block;"><bdi dir="auto" style="display: block;">Explore the cuisines of Brittany, Provence, Corsica and Paris from the comfort of your hosts\'s home. You\'ll embark on a culinary tour of France during this typically French dinner.</bdi><bdi dir="auto" style="display: block;"><br></bdi><bdi dir="auto" style="display: block;">• 4-course dinner featuring specialities from all around France</bdi><bdi dir="auto" style="display: block;">• Aperitif and wine are included, guests can also BYOB</bdi><bdi dir="auto" style="display: block;">• Communal dining for 5 to 12 people</bdi><bdi dir="auto" style="display: block;">• Françoise has over 35 rave reviews on TripAdvisor!&nbsp;</bdi><bdi dir="auto" style="display: block;"><br></bdi><bdi dir="auto" style="display: block;">About your host, Françoise: "I\'m a chef with my own catering company that caters for companies like Café Elephant Paname, luxury brands, magazines, Fashion Week shows and photo production teams. I can’t eat anything without smelling it before and I always spend a couple of days a month abroad to discover new food."</bdi></bdi></bdi></bdi></p><h3 class="__title" dir="auto" style="font-family: circular, sans-serif; line-height: 1.1; color: rgb(143, 142, 135); margin-top: 24px; margin-bottom: 32px; font-size: 2rem; letter-spacing: 1px; text-transform: uppercase;">MENU</h3><p><bdi dir="auto" style="text-align: justify; display: block;"><bdi dir="auto" style="display: block;"><bdi dir="auto" style="display: block;"><bdi dir="auto" style="display: block;"></bdi></bdi></bdi></bdi></p><div class="EventPage-Menu" style="color: rgb(53, 53, 48); font-family: circular, sans-serif;"><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">APERITIF</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">SEASONAL COCKTAIL BOUCHÉES</h5></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">ENTREE</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">THE CHEESE SOUFFLÉ</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">a classic from Parisian brasseries<br></bdi><bdi dir="auto" style="display: block;">served with aromatic herbs, fruits &amp; salad mix<br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">MAIN COURSE</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">"BOEUF BOURGUIGNON À LA PROVENÇALE"</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">THE "Daube Niçoise", macerated all night in Madiran wine <br></bdi><bdi dir="auto" style="display: block;">and slow-cooked for 6 hours like a confit.<br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">FIRST DESSERT</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">LEMON FIADONE</h5><p class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;"><bdi dir="auto" style="display: block;">speciality from Corsica<br></bdi><bdi dir="auto" style="display: block;"><br></bdi></p></div><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><h4 class="__descriptionTitle" dir="auto" style="font-family: circular, sans-serif; line-height: 18px; color: rgb(53, 53, 48); margin-top: 11px; margin-bottom: 4px; font-size: 1.4rem; text-transform: uppercase; letter-spacing: 3px;">SECOND DESSERT</h4><div><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">RED FRUITS IN A REFRESHING MINT JUICE OR ROSE AND CITRUS FRUITS</h5></div></div><div class="__menuDescription" style="text-align: center; font-size: 1.6rem; line-height: 24px; letter-spacing: 1px; padding-bottom: 16px;"><hr class="separator" style="margin-top: 22px; margin-bottom: 22px; border-top-color: rgb(223, 226, 231); width: 148.792px;"><h5 dir="auto" class="__itemTitle" style="font-family: circular, sans-serif; line-height: 1.1; margin-bottom: 11px; font-size: 2rem; text-transform: uppercase; letter-spacing: 3px;">BOISSONS</h5><p dir="auto" class="__itemBody" style="margin-right: 0px; margin-bottom: 11px; margin-left: 0px; color: rgb(143, 142, 135); white-space: pre-line; font-size: inherit; letter-spacing: 0px;">Les invités peuvent apporter de l\'alcool, Vin, Apéritif</p></div></div><p></p><p></p>');
        $meal3->setPrice(40);
        $date = date_create_from_format('j-M-Y', '12-Feb-2009');
        $meal3->setDateMeal($date);
        $meal3->setMaxTraveller(8);
        $meal3->setHost($user2);
        $meal3->setAddress($address2);
        $manager->persist($meal3);

        //////////////////////////////////////BOOKINGS/////////////////////////////////////
        //user2 reserve un repas chez $user1
        $booking1 = new Booking();
        $booking1->setIsPayed(false);
        $booking1->setMeal($meal1);
        $booking1->setTraveler($user2);
        $booking1->setIsAccepted(false);
        $manager->persist($booking1);

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
              $notation->setGiver($user2);}else{$notation->setGiver($otherUser);
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
         $message->setSender($otherUser);
         $message->setReceiver($user1);
         $manager->persist($message);
         $manager->flush();

         $message = new Message();
         $message->setContent($faker->text);
         $message->setStatus("envoyé");
         $message->setCreatedAt(date_create_from_format('j-M-Y', '29-Feb-2009'));
         $message->setSender($user1);
         $message->setReceiver($otherUser);
         $manager->persist($message);
         $manager->flush();
    }

}
