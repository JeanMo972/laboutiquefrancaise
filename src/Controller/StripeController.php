<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Classe\Cart;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{

    #[Route('/commmande/create-session', name: 'stripe_create_session')]
    public function index(Cart $cart): Response
    {
        
        $products_for_stripe = [];

        //route 
        $YOUR_DOMAIN = 'http://127.0.0.1:8000/public';

        foreach ($cart->getFull() as $product) {
            //intégration de STRIPE
            $products_for_stripe[]= [ //permet d'afficher le recapitulatif de la commande avant payment
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product['product']->getPrice(),
                    'product_data' => [
                        'name' => $product['product']->getName(),
                        'images' => ["http://127.0.0.1:8000/public/uploads"],
                    ],
                 ],
                'quantity' => ($product['quantity'])

            ];

        }

        //transporteur
        //$products_for_stripe[]= [ //permet d'afficher le transporteur avant payment
            //'price_data' => [
                //'currency' => 'eur',
                //'unit_amount' => $product['product']->getPrice(),
                //'product_data' => [
                    //'name' => $product['product']->getName(),
                    //'images' => ["http://127.0.0.1:8000/public/uploads"],
                //],
             //],
            //'quantity' => ($product['quantity'])

        //];
            
             // This is your test secret API key.
            Stripe::setApiKey('sk_test_51LieBcK9e2s2wv9Gi1NS8b76qXmJ6xCJk5CSUfVvlCqK9IdYn4CFmeRxgt8lOmKbFWUK3vtarSS76Zhs8APlKni400ZjmaraJV');

            $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [

            $products_for_stripe 

            ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/commande/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/commande/erreur/{CHECKOUT_SESSION_ID}',
          ]);

          //$response = new JsonResponse(['id' => $checkout_session->id]);
          return $this->redirect($checkout_session->url);
    }
       
}
