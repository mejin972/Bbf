<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountOrderController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/compte/mes_commande", name="account_order")
     */
    public function index(): Response
    {
        $orders = $this->entityManager->getRepository(Order::class)->findSuccessOrders($this->getUser());
        //dd($orders);
        return $this->render('account/mes_commande.html.twig',[
            'orders' => $orders,
        ]);
    }

     /**
     * @Route("/compte/mes_commande/detail/{reference}", name="accountOrder_detail")
     */
    public function detail($reference): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findByReference($reference);
        //dd($order);
        return $this->render('account/mesCommandes_detail.html.twig',[
            'order'=>$order
        ]);
    }
}
