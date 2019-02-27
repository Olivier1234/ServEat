<?php

namespace App\Controller;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Message;
use App\Entity\User;

class PageController extends AbstractController
{
    /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('page/about.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('page/contact.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/add_listing", name="add_listing")
     */
    public function add_listing()
        {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('page/add_listing.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/bookings", name="bookings")
     */
    public function bookings()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('page/bookings.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/messages", name="messages", methods={"GET"})
     * Affiche toues les messages reçus et envoyés de l'utilisateur
     */
    public function messages(MessageRepository $messageRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $messages = $messageRepository->findAllMessages($user);
        $distinct_messages = array();
        $receiver_array = array();

        foreach ($messages as $message) {
            if (!in_array($message->getReceiver(),$receiver_array)) {
                array_push($distinct_messages, $message);
                array_push($receiver_array, $message->getReceiver());
            }
        }

        return $this->render('page/messages.html.twig', [
            'controller_name' => 'PageController',
            'messages' => $distinct_messages,
            'user' => $user,
            'title' => "Toutes les conversations"

        ]);
    }

    /**
     * @Route("/messages/{id}", name="messages_user", methods={"GET"})
     * Affiche tous les messages avec un utilisateur en particulier
     */
    public function messages_user(MessageRepository $messageRepository, User $other)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        var_dump($user->getUsername());
        var_dump($other->getUsername());


        return $this->render('page/messages.html.twig', [
            'controller_name' => 'PageController',
            'messages' => $messageRepository->findAllMessagesUser($user, $other),
            'user' => $user,
            'title' => "Votre conversation avec " . $other->getFullName()

        ]);
    }

    /**
     * @Route("/messages/create", name="message_create", methods={"POST"})
     */
    public function new_message(MessageRepository $messageRepository, Request $request)
    {
        $message = new Message();
        $message->setContent("prout");
        $message->setStatus("envoyé");
        $message->setSender();
        $message->setReceiver();

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

        $form = $this->createForm(Message::class, $message);

        $form->handleRequest($request);
        var_dump("lol", $request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var $userManager UserManagerInterface */


        }

    }


    /**
     * @Route("/user_profile", name="user_profile")
     */
    public function user_profile()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('page/user_profile.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/change_password", name="change_password")
     */
    public function change_password()
    {
        return $this->render('page/change_password.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/reviews", name="reviews")
     */
    public function reviews()
        {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('page/reviews.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard()
        {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        return $this->render('page/dashboard.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/concept", name="concept")
     */
    public function concept()
    {
        return $this->render('page/concept.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/member", name="member")
     */
    public function member()
    {
        return $this->render('page/member.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/listing", name="listing")
     */
    public function listing()
    {
        return $this->render('page/listing.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
}
