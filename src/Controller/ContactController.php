<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/contactez_nous", name="contact")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash(
                'notif_mail',
                "Merci d'avoir pris contact avec nous, nous allons vous répondre dans les plus bref délai"
            );
            //dd($form->getData());
            $email = $form->getData()["mail"];

            $isUser = $this->entityManager->getRepository(User::class)->findOneByEmail($email);
            //dd($isUser);
            $isRegistered = "non";
            if ($isUser) {
                $isRegistered = "oui "."id User n°: ".$isUser->getId();
            };

            $mail = new Mail;
            $mail->contactFromCustumersSend(
                'mejin972@gmail.com',
                $form->getData()["prenom"]." ".$form->getData()["nom"],
                $form->getData()["prenom"],
                $form->getData()["nom"],
                $form->getData()["contenu"],
                $isRegistered,
                $form->getData()["mail"]
            );
        }
        return $this->render('contact/index.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}
