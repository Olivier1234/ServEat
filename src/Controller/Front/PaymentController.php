<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class PaymentController extends AbstractController
{
    /**
     * @Route("/payment", name="payment")
     */
    public function payment(Request $request)
    {
        
        
        return $this->render('payment/payment.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }

     /**
     * @Route("/charge", name="charge")
     */
    public function charge(Request $request)
    {
        //dd($_POST);
// Set your secret key: remember to change this to your live secret key in production
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey('sk_test_eVxSmneYt3p7j9FH32xajzmG');

       // Charge the Customer instead of the card:
$charge = \Stripe\Charge::create([
    'amount' => 1000,
    'currency' => 'usd',
    'customer' => $customer->id,
]);

       return $this->render('payment/payment.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }
        
        
}
