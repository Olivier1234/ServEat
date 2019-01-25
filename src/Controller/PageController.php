<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/messages", name="messages")
     */
    public function messages()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        return $this->render('page/messages.html.twig', [
            'controller_name' => 'PageController',
        ]);
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


