<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/*
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
*/
class StripeController extends AbstractController
{
    /**
     * @Route("/commande/create-checkout-session/{reference}", name="stripe_create_session")
     */
    public function index(EntityManagerInterface $entityManager , Cart $cart , $reference)
    {
        //dd($reference);
        $order = $entityManager->getRepository(Order::class)->findOneByReference($reference);
        $trans = 1;
        $product_for_stripe = [];
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';

        foreach ($order->getOrderDetails()->getValues() as $product) {
            $product_object = $entityManager->getRepository(Products::class)->findOneByName($product->getProduct());
            //dd($product);
            $product_for_stripe[] = [
                'price_data' =>
                [
                    'currency' => 'eur',
                    'unit_amount' => $product->getPrice(),
                    'product_data' => [
                        'name' => $product->getProduct(),
                        /*'images' => ['uploads/creaProduct/'.$product['product']->getIllustration()], En chemin d'accès   */
                        'images' => [ $YOUR_DOMAIN.'/uploads/creaProduct/'.$product_object->getIllustration()],// Version URL d'accès.
                    ],  
                ],
                'quantity' => $product->getQuantity(),
                //dd($product->getQuantity()),
            ];
        }


        $product_for_stripe[] = [
            'price_data' =>
            [
                'currency' => 'eur',
                'unit_amount' => $order-> getCarrierPrice(),
                'product_data' => [
                    'name' => $order->getCarrierName(),
                    /*'images' => ['uploads/creaProduct/'.$product['product']->getIllustration()], En chemin d'accès   */
                    'images' => [ $YOUR_DOMAIN],  
                ],
            ],   
            'quantity' => 1,
            
        ];
        //dd($product_for_stripe);

        Stripe::setApiKey('sk_test_51JGHUHB7q2tRktins2LGEPoU8nMuaxNMuDLfqIuFyA9cAoX6prZLnJvq6H0jjFvaBDWh6bh6A2MzFvzrEMEWmRkp00iieIFtkj');
        
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';
        if ($order) {
            //dd($product_for_stripe);
            $checkout_session = Session::create([
                'customer_email'=> $this->getUser()->getEmail(),
                'payment_method_types' => ['card'],
                'line_items' =>
                [
                    $product_for_stripe
                ],
                'mode' => 'payment',
                'success_url' => $YOUR_DOMAIN . '/commande/merci/{CHECKOUT_SESSION_ID}',
                'cancel_url' => $YOUR_DOMAIN . '/commande/error/{CHECKOUT_SESSION_ID}',
            ]);

            $order ->setStripeSessionId($checkout_session->id);
            $entityManager->flush(); //Besoin de persist la data que dans la phase de création. Ici elle a deja été crée.
            
            return $this->redirect($checkout_session->url,302);
            //dd($checkout_session->url);
        }else {
            $error = 'order not found';
            return $this->redirectToRoute('');
        }
        //dd($order);
        
       
    }
}
       
        //header("HTTP/1.1 303 See Other");
        //header("Location: " . $checkout_session->url);
        

        //$reponse = new JsonResponse(['id' => $checkout_session->id]);
        //return $reponse ;

       /* return $this->render('stripe/index.html.twig', [
            'controller_name' => 'StripeController',
        ]);*/