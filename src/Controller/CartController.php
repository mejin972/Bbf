<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session){
        $this->entityManager = $entityManager;
        $this->session = $session;
    }

    /**
     * @Route("/mon_panier", name="cart")
     */
    public function index(Cart $cart): Response // il faut aussi embarquer cart ici
    {

        // il faut crée la methode get dans la class.

            //dd($this->session->get('cart'));

        //dd($cart); 
        return $this->render('cart/index.html.twig',[
            'cart'=>$cart->getfull()
        ]);

    }

    /**
     * @Route("/cart/add/{id}", name="add_to_cart" )
     */
    public function add(Cart $cart ,$id): Response
    {
        
        $cart->add($id); // Pour utiliser cette vraible il faut embarquer la class cart dans le controller,

        $produit_ajouter = $this->entityManager->getRepository(Products::class)->findOneById($id);
        $name_add_product = $produit_ajouter->getName();
        //dd($name_add_product);

        $this->addFlash(
            'notification_cart',
            'Le produit à bien été ajouter aux panier '. $name_add_product,
        );
        
        return  $this->redirectToRoute('cart');// a la place de rendre une vue on effectue une redirection vers le panier qui affichera le recap de l'ajout.
    }

    /**
     * @Route("/cart/add/{id}/{quantity}", name="add_to_cart_quantity" )
     */
    public function addWithSelect(Cart $cart ,$id ,$quantity): Response
    {
        
        $cart->addWithQuantity($id, $quantity); // Pour utiliser cette vraible il faut embarquer la class cart dans le controller,
        
        return  $this->redirectToRoute('cart');// a la place de rendre une vue on effectue une redirection vers le panier qui affichera le recap de l'ajout.
    }


    /**
     * @Route("/cart/supprimer", name="remove_my_cart")
     * 
     * va supprimer l'ensemble du panier
     */
    public function remove(Cart $cart): Response
    {
        
        $cart->remove(); 
        return  $this->redirectToRoute('products');// a la place de rendre une vue on effectue une redirection vers les produits après la supression.
    }


    /**
     * @Route("/cart/supprimer_produit/{id}", name="delete_to_cart")
     * 
     * va supprimer le produit du panier
     */
    public function delete(Cart $cart, $id): Response
    {
        $cart->delete($id); 
        return  $this->redirectToRoute('cart');// a la place de rendre une vue on effectue une redirection vers les produits après la supression.
    }


    /**
     * @Route("/cart/diminuer_produit/{id}", name="decrease_to_cart")
     * 
     * va dinminuer la quantite du produit dans le panier
     */
    public function decrease(Cart $cart, $id): Response
    {
        $cart->decrease($id); 
        return  $this->redirectToRoute('cart');// a la place de rendre une vue on effectue une redirection vers les produits après la supression.
    }
}

