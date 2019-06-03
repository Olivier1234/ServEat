<?php

namespace App\Controller\Front;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Entity\User;

/**
 * @Route("/messages", name="front_message_")
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * Affiche tous les messages reçus et envoyés de l'utilisateur courant
     */
    public function index(MessageRepository $messageRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $messages = $messageRepository->findAllMessages($user);
        $distinct_messages = array();
        $receiver_array = array($user);

        // On regroupe les messages des utilisateurs
        foreach ($messages as $message) {
            if ((!in_array($message->getReceiver(),$receiver_array))
            && $message->getReceiver()) {
                array_push($distinct_messages, $message);
                array_push($receiver_array, $message->getReceiver());
            }
        }

        return $this->render('front/message/index.html.twig', [
            // 'controller_name' => 'MessageController',
            'messages' => $distinct_messages,
            'user' => $user,
            // 'count' => $messageRepository->countMessageStatus($user, "envoyé")
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(MessageRepository $messageRepository, UserRepository $userRepository, Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $other = $userRepository->find($request->request->get('other'));

        $message = new Message();
        $message->setContent($request->request->get('message'));
        $message->setStatus("envoyé");
        $message->setSender($user);
        $message->setReceiver($other);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($message);
        $entityManager->flush();

        return $this->render('front/message/show.html.twig', [
            // 'controller_name' => 'MessageController',
            'messages' => $messageRepository->findAllMessagesUser($user, $other),
            'user' => $user,
            'other' => $other,
            'title' => "Votre conversation avec " . $other->getUserName()
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET","POST"})
     * Affiche tous les messages avec un utilisateur en particulier
     */
    public function show(MessageRepository $messageRepository, User $other): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        return $this->render('front/message/show.html.twig', [
            // 'controller_name' => 'MessageController',
            'messages' => $messageRepository->findAllMessagesUser($user, $other),
            'user' => $user,
            'other' => $other
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    // public function edit(Request $request, Message $message): Response
    // {
    //     $form = $this->createForm(MessageType::class, $message);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $this->getDoctrine()->getManager()->flush();

    //         return $this->redirectToRoute('index', [
    //             'id' => $message->getId(),
    //         ]);
    //     }

    //     return $this->render('front/message/edit.html.twig', [
    //         'message' => $message,
    //         'form' => $form->createView(),
    //     ]);
    // }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Message $message): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/count/{status}", name="count_status", methods={"GET"})
     * Compte tous les messages avec un param status
     */
    // public function count_status(MessageRepository $messageRepository, string $status)
    // {
    //     $user = $this->getUser();
    //     $count = $messageRepository->countMessageStatus($user, $status);
    //     return new JsonResponse($count[0][1]);
    // }
}
