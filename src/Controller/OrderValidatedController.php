<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderValidatedController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/commande/merci/{stripeSessionId}", name="order_validated")
     */
    public function index(Cart $cart,$stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);
        $nameProduct_mail = [];
        foreach ($order->getOrderDetails()->getValues() as $product) {
            $nameProduct_mail = $product->getProduct();
        }
        //dd($order->getReference());
        if (!$order || $order->getUser() != $this->getUser() ) {
            return $this->redirectToRoute('home');
        }
        // Passer le statut isPaid a 1 car le paiment à éteé valider
        if ($order->getState() == 0) {
            $order->setState(1);
            $this->entityManager->flush();
            // Vider la session "cart".
            $cart->remove();
            //Envoyer un mail au client pour confirmaer la commande de l'utilisateur 
        }
        
        $mail =new Mail;
        $mail->send(

            'mejin972@gmail.com', 
            $order->getUser()->getFirstname(),
            "Votre comfirmation de commande" , 
            ($order->getCarrierPrice() / 100 )." € ", 
            $order->getCarrierName() , $nameProduct_mail , 
            $order->getUser()->getFirstname() , 
            $order->getReference()
        );
        
        //Afficher les infos de la commande a l'utilisateur.
        return $this->render('order_validated/merci.html.twig',[
            'order' =>$order,
        ]);
    }
}
