<?php
/**
 * Created by PhpStorm.
 * User: ying
 * Date: 16/01/2019
 * Time: 18:18
 */

namespace App\Controller\Front;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/search")
 */
class SearchController extends AbstractController
{
    /**
     * @Route("/", name="searchPage", methods="GET")
     */
    public function index()
    {
        return $this->render('front/search.html.twig');
    }

    /**
     * @Route("/", name="search", methods="POST")
     */
    public function search(Request $request) : Response
    {
        var_dump($request);
        // $user = new User();
        // $form = $this->createForm(UserType::class, $user);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->persist($user);
        //     $entityManager->flush();

        //     return $this->redirectToRoute('user_index');
        // }

        // return $this->render('user/new.html.twig', [
        //     'user' => $user,
        //     'form' => $form->createView(),
        // ]);
    }
}