<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home", methods={"GET","POST"}))
     */
    public function home()
    {
        return $this->render('front/home/home.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
