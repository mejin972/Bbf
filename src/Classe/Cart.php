<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;

class Cart{

    private $session;
    private $entityManager;

public function __construct( EntityManagerInterface $entityManager, SessionInterface $session )  //On injecte la dependace session interface
    {
        $this->session = $session; //Pour le rendre accesible dans la function.
        $this->entityManager = $entityManager;
    }

    public function add($id){

        $cart = $this->session->get('cart', []);

        if (!empty($cart[$id])) {
            $cart[$id]++;
        }else{
            $cart[$id] = 1;
        }

        $this->session->set('cart', $cart);
    }

    public function addWithQuantity($id, $quantity){

        $cart = $this->session->get('cart', []);
        
        
 
        if ( (!empty($cart[$id])) && (!empty($quantity)) ) {
            $cart[$id] = $quantity;
            /*$cart = [
                $id => $quantity,
            ];*/
        }
        else{
            $cart[$id] = 1;
        }
        
        $this->session->set('cart', $cart);
    }

    public function get(){
        return $this->session->get('cart');
    }

    public function remove(){
        return $this->session->remove('cart');
    }

    public function delete($id){
        $cart = $this->session->get('cart', []);
        dump($cart);
        unset($cart[$id]);// retirer du array cart le produit qui porte l'Id passer en parametre.
        //dd($cart);
        return $this->session->set('cart', $cart); // et apres delete on doit set le array modifier
    }

    public function decrease($id){
        $cart = $this->session->get('cart', []);

        if($cart[$id] > 1){
            $cart[$id]--;
        }else {
            unset($cart[$id]);
        }
        return $this->session->set('cart', $cart);
    }

    public function getfull(){
        $cartComplet = [];

        /* if() rajouter car error inopiner du foreach sur panier vide*/
        if ($this->get()) {

           /* $this->get() than $cart->get() because we are in same class no need variable here*/
            foreach ($this->get() as $id => $quantity) {
                 /* secure la requete au cas ou l'utilisateur tape un id qui n'existe pas dans l'url*/   
                $product_object = $this->entityManager->getRepository(Products::class)->findOneById($id);
                if (!$product_object) {
                    $this->delete($id);
                    continue; /* dans se cas le systeme passera au produit suivant sans affectuer le faux produit*/
                }

                $cartComplet[] = [
                    'product' => $product_object,
                    'quantity' => $quantity,
                ];
            }
        }
        

        return $cartComplet;
    }
}






?>