<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class RegisterController extends AbstractController
{
    

    private $entityManager; // Convention de symfony, car on utilise le manager de doctrine.

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * 
     * @Route("/inscription", name="register")
     * 
     * a bien place devant la function qui retourne le page sinn la route est undifined
     * 
     */


    public function index(Request $request,UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            
            $user = $form->getData();
            //dd($user);

            // permet de hasher le mot de passe
            $password = $encoder->encodePassword($user,$user->getPassword());

            $user->setPassword($password);// permet de réinjecter le password hasher dans la variable password du user.

            //$doctrine = $this->getDoctrine()->getManager(); // permet d'avoir doctrine

            $email_exists = $this->entityManager->getRepository(User::class)->findByEmail($user->getEmail());

            if (!empty($email_exists)){
                //dd($email_exists);
                $this->addFlash(
                    'notification_register',
                    "L'email que vous avez utiliser est déja ratacher à un compte veuiller vous connecter"
                );
                return $this->redirectToRoute('app_login');
            }else {

                $this->entityManager-> persist($user);// persit() permet de figer la data ,car on auras besoin de l'enregistrer.
                $this->entityManager-> flush();// execute le persistance, enrgistre la data.
                
                $this->addFlash(
                    'notification_register',
                    "<div class='alert alert-success'>
                        <p> Vos donner ont bien été enregistrer </p>
                    </div>",
                );
    
                $registerComfirmationMail = new Mail;
                $registerComfirmationMail->registerSend($user->getUserIdentifier(), $user->getFirstname(), $user->getFirstname());
            }
            //Permet de débuger et de voir le contenu d'une variable dd().
            //dd($user); 
            
           

            //dd($password);
        }


        return $this->render('register/index.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
    