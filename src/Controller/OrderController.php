<?php

namespace App\Controller;


use App\Classe\Cart;
use App\Entity\Order;
use App\Form\OrderType;
use App\Entity\OrderDetails;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/commande", name="order")
     */
    public function index(Cart $cart, Request $request ): Response
    {
        //dd($this->getUser()->getAdresses()->getValues());  /* $this->getUser() super methode pour recupére le user current; ->getAdresses poour ces adresses ; et pour obtenir le ou les data on utilise ->getValues de Doctrine ORM */
        if (!$this->getUser()->getAdresses()->getValues()) {
            return $this->redirectToRoute('account_adress_add');
        }
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser() // on passe l'objet User au form pour qu'il recupère bien les adress du l'utilisatuer connecter.
        ]);

        return $this->render('order/index.html.twig',[
            'form' => $form->createView(),
            'cart' => $cart->getfull()
        ]);
    }

    /**
     * @Route("/commande/recapitulatif", name="order_recapitulatif", methods={"POST"})
     * 
     * Le paramètre methode definit le type de requete accepter ici uniquement POST. 
     * Un autre type ne pourra pas accéder a cette route.
     */
    public function add(Cart $cart, Request $request ): Response
    {
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser() // on passe l'objet User au form pour qu'il recupère bien les adress du l'utilisatuer connecter.
        ]);


        $form->handleRequest($request);

        if ( $form->isSubmitted()  && $form->isValid()) {
            //dd($form->get('addresses')->getData());
            

            $date = new \DateTime();
            $carrier = $form->get('Carrier')->getData();
            $delivery = $form->get('addresses')->getData();
            $delivery_Content = $delivery->getFirstname().'<br/>'.$delivery->getLastname();
            $delivery_Content .= '<br/>'.$delivery->getPhone();
            if ($delivery->getCompany()) {
                $delivery_Content .= '<br/>'.$delivery->getCompany(); 
            }

            $delivery_Content .= '<br/>'.$delivery->getAddress();
            $delivery_Content .= '<br/>'.$delivery->getCodePostal().''.$delivery->getCity();
            $delivery_Content .= '<br/>'.$delivery->getPays();
            
            //dd($delivery_Content);

            //Enregistre me commande Order;
             
            $order = new Order;
            $reference = $date->format('dmy').'-'.uniqid();
            $order->setReference($reference);
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setCarrierName($carrier->getName());
            $order->setCarrierPrice($carrier->getPrice());
            $order-> setDelivery($delivery_Content);
            $order->setState(0);
            //dd($order);

            $this->entityManager->persist($order);// on persiste d'abord order

            //Enregistre mes produits OrderDetails;

            

            foreach ($cart->getFull() as $product) {
                $orderDetails = new OrderDetails;
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['product']->getName());
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice($product['product']->getPrice());
                $orderDetails->setTotal($product['product']->getPrice() * $product['quantity']);
                //dd($product);

                $this->entityManager->persist($orderDetails);// en second les orderDetails.

                
            }
            
            $this->entityManager->flush();

            //dd($product_for_stripe);
            //dd(['uploads/creaProduct/'.$product['product']->getIllustration()]);
            

            //Stripe::setApiKey('sk_test_51JGHUHB7q2tRktins2LGEPoU8nMuaxNMuDLfqIuFyA9cAoX6prZLnJvq6H0jjFvaBDWh6bh6A2MzFvzrEMEWmRkp00iieIFtkj');

            /*$YOUR_DOMAIN = 'http://127.0.0.1:8000';
            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' =>
                [
                    $product_for_stripe
                ],
                'mode' => 'payment',
                'success_url' => $YOUR_DOMAIN . '/success.html',
                'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
            ]);*/

            //dump($checkout_session->id);
            //dd($checkout_session);


            /* On place le return dans le if pour être sur que la vue add ne sera rendu que si on vien du POST*/
            return $this->render('order/add.html.twig',[
                'cart' => $cart->getfull(),
                'carrier' => $carrier ,// Pour recupérer le montant de livraison dans notre vue.
                'delivery' => $delivery_Content,
                'reference' => $order->getReference()
        
            ]);
        }

       return $this->redirectToRoute('cart');
    }
}
