<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use App\Form\SearchType;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/nos-produits", name="products")
     */
    public function index(Request $request): Response
    {

        $search = new Search;
        $form = $this->createForm(SearchType::class, $search);
        //$newForm = $this->createForm(FilterSelectType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            //$search = $form->getData(); n'est pas nécessaire ici car search est deja lié au form
            $products = $this->entityManager->getRepository(Products::class)->findWithSearch($search);
            //dd($search, $search->q, $products);
        }else {
            $products = $this->entityManager->getRepository(Products::class)->findAll();
        }

        //dd($products);
        
        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
            //'formSelect' => $newForm->createView(),
        ]);
    }

    /**
     * @Route("/produit/{slug}", name="product")
    */
    public function show($slug): Response
    {
        //dd($slug);
        $product = $this->entityManager->getRepository(Products::class)->findOneBySlug($slug);

        if(!$product) {
            return $this->redirectToRoute('products');
        }

        return $this->render('product/show.html.twig', [
            'product'=> $product
        ]); 
    }

}
