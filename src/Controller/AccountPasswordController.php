<?php

namespace App\Controller;

use App\Form\ChangePasswordType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountPasswordController extends AbstractController
{


    private $entityManager;

    /**
     * AccountPasswordController constructor.
     * @param $entityManager
     */

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/compte/modifier_password", name="account_password")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $notification = null;
        $error = null;
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
           $old_psw = $form->get('old_password')->getData();
            if ($encoder->isPasswordValid($user, $old_psw)) {
                $new_psw = $form->get('new_password')->getData();
                $password =$encoder->encodePassword($user, $new_psw);

                $user->setPassword($password);
                $this->entityManager-> persist($user);// Dans le cas d'une mise a joour d'info le persist() n'est pas nécessaire
                $this->entityManager->flush();
                $notification = "Votre mot de passe à bien été modifier";
            }else{
                $error = "Votre mot de passe actuel est incorect";
            }
        }


       // dd($user);
        
        return $this->render('account/password.html.twig',[
            'form' => $form->createView(),
            'notification' => $notification,
            'error'=> $error
        ]);
    }
}
