<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderCancelController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/commande/error/{stripeSessionId}", name="order_cancel")
     */
    public function index($stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);
        $nameProduct_mail = [];
        foreach ($order->getOrderDetails()->getValues() as $product) {
            $nameProduct_mail = $product->getProduct();
        }
        if (!$order || $order->getuser() != $this->getUser()) {
            return $this->redirectToRoute('home');
        }

        //Envoie mail a l'utilisateur pour comfirmer l'echec.

        $mail =new Mail;
        $mail->infoRejectSend(
            'mejin972@gmail.com', 
            $order->getUser()->getFirstname(),
            $order->getReference()
        );

        return $this->render('order_cancel/echec.html.twig',[
            'order' => $order,
        ]);
    }
}
