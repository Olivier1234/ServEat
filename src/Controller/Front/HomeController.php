<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="front_", methods={"GET","POST"}))
 */
class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home", methods={"GET","POST"}))
     */
    public function home()
    {

        $searchForm = $this->createFormBuilder()
            ->setAction($this->generateUrl('front_search_search'))
            ->setMethod('GET')
            ->add('adressInput', TextType::class)
            ->add('submit', SubmitType::class, ['label' => 'Rechercher'])
            ->getForm();


        return $this->render('front/home/home.html.twig', [
            'controller_name' => 'HomeController',
            'searchForm' => $searchForm->createView(),
        ]);
    }
}
