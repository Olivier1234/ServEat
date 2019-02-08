<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/home", name="front_", methods={"GET","POST"}))
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET","POST"}))
     */
    public function home()
    {
        return $this->render('front/home/home.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
