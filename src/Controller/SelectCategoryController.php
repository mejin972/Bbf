<?php

namespace App\Controller;




use App\Entity\Products;
use App\Classe\SearchCategory;
use App\Form\FormCategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SelectCategoryController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/select/category/{category}", name="select_category")
     */
    public function index($category, Request $request): Response
    {
        
        $form = $this->createForm(FormCategoryType::class);

        $form->handleRequest($request);
        
        switch ($category) {
            case 'Manteaux':
                $code = '1';
                $products = $this->entityManager->getRepository(Products::class)->findByCategory($code);
                break;
            case 'Bonnets':
                $code = '2';
                $products = $this->entityManager->getRepository(Products::class)->findByCategory($code);
                break;
            case 'T-shirt':
                $code = '3';
                $products = $this->entityManager->getRepository(Products::class)->findByCategory($code);
                break;
            case 'Echarpes':
                $code = '4';
                $products = $this->entityManager->getRepository(Products::class)->findByCategory($code);
                break;
            case 'Homme':
                $genre = "HOMME";
                $mix = "MIXTE";
                $products = $this->entityManager->getRepository(Products::class)->findByGenre([$genre,$mix]);
                break;
            case 'Femme':
                $genre = "FEMME";
                $mix = "MIXTE";
                $products = $this->entityManager->getRepository(Products::class)->findByGenre([$genre,$mix]);
                break;
            
            default:
                $code = '0';
                $products = $this->entityManager->getRepository(Products::class)->findAll();
                break;
        }

        if ($form->isSubmitted() && $form->isValid()){
            //dd($form->get('recherche')->getData());
            $name = $form->get('recherche')->getData();
            if (!empty($name)){
                $products = $this->entityManager->getRepository(Products::class)->findByName($name);

            }
            
            //dd($name);
        }
    
        return $this->render('select_category/index.html.twig',[
            'products' => $products,
            'category' => $category,
            'form' => $form->createView()
        ]);
    }
}
