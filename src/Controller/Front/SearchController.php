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
 * @Route("/search", name="front_search_")
 */
class SearchController extends AbstractController
{
    /**
     * @Route("/", name="index", methods="GET")
     */
    public function index()
    {
        return $this->render('front/search.html.twig');
    }

    /**
     * @Route("/new", name="search", methods="GET")
     */
    public function search(Request $request) : Response
    {
        // $user = new User();
        // $form = $this->createForm(UserType::class, $user);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->persist($user);
        //     $entityManager->flush();

        //     return $this->redirectToRoute('front_user_index');
        // }

         return $this->render('front/search.html.twig', []);
    }
}
