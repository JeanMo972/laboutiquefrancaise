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

    #[Route('/commmande/create-session', name: 'sripe_create_session')]
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
                        'images' => ["http://127.0.0.1:8000/public"],
                    ],
                 ],
                'quantity' => ($product['quantity'])

            ];

        }
        
             // This is your test secret API key.
            Stripe::setApiKey('sk_test_51LieLtLv8IqE4Bc33y5pBGo6yAejtL8r2dWK2dYNIWdtsoberogQoaAVJUR87Eo2P8qWvpjQbkLGvpHqoWmv8CQC002PvXPEkR');

            $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [

            $products_for_stripe 

            ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/success.html',
            'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
          ]);

          //$response = new JsonResponse(['id' => $checkout_session->id]);
          return $this->redirect($checkout_session->url);
    }
       
}
