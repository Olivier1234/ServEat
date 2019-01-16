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

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="searchPage", methods="GET")
     */
    public function index()
    {
        return $this->render('front/search.html.twig');
    }
}