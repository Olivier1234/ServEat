<?php
/**
 * Created by PhpStorm.
 * User: ying
 * Date: 16/01/2019
 * Time: 18:18
 */

namespace App\Controller\Front;


use App\Entity\Meal;
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
    public function show(Request $request) : Response
    {
        var_dump($request->query->get('adressInput'));
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

    /**
     * @Route("/ajax_search", name="ajax_search", methods="GET")
     */
    public function ajaxSearch(Request $request)
    {
        $posX = $request->query->get('posX');
        $posY = $request->query->get('posY');


        dump($posX, $posY);

        $meals = $this->getDoctrine()
            ->getRepository(Meal::class)
            ->findMealsByPositions($posX, $posY);

        dump($meals);

        $response = new Response(
            'Content',
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );
        $result = json_encode($meals);

        $response->setContent($result);
        $response->setCharset('ISO-8859-1');
        $response->headers->set('Content-Type', 'text/html');
        $response->prepare($request);
        dump($response);
//        $response->send();
        return $response;
        // $user = new User();
        // $form = $this->createForm(UserType::class, $user);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->persist($user);
        //     $entityManager->flush();

        //     return $this->redirectToRoute('front_user_index');
        // }

//        return $this->render('front/search.html.twig', []);
    }
}
