<?php

namespace App\Controller;

use DateTime;
use App\Classe\Mail;
use App\Entity\User;
use App\Entity\ReinitialiserPassword;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ResetPasswordController extends AbstractController
{
    /* On doit vérifier si l'email existe en base de donnée ou non*/ 
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
        // $this->entityManager->getRepository(User::class)->findOneByEmail($email);
    }


    /**
     * @Route("/reset/password", name="reset_password")
     */
    //On injecte Request pour que le controleur soit capable de capter se qu'il se passe dans le formulaire.
    public function index(Request $request): Response
    {

        $email = $request->get('email');

        if ($this->getUser()) {
            //Si l'utilisateur est deja connecter il sera rediriger vers la page d'acceuil.
            // Ou ajout d'un addFlash pour signifier qu'il est déja connecter.
            $this->redirectToRoute('home');
        }

        if ($email) {
            //dd($request->get('email'));
            $user = $this->entityManager->getRepository(User::class)->findOneByEmail($email);
            if (!$user) {
                /* 
                    $this->addFlash() is equivalent to $request->getSession()->getFlashBag()->add()
                    https://symfony.com/doc/current/controller.html#flash-messages
                */
                $this->addFlash(
                   'error',
                   "Cette utilisateur n'existe pas. Veuillez réesayer ou <a href='/inscription'> crée un compte </a>"
                );
            }else {
                /* 
                    Si $user exite:
                        - set User
                        - set create at
                        - set idenfUser

                */
                $reinitialiser_mot_de_passe = new ReinitialiserPassword;
                $reinitialiser_mot_de_passe->setUser($user);
                /*
                    uniqid(string $prefix = "", bool $more_entropy = false): string
                    https://www.php.net/manual/fr/function.uniqid.php
                */    
                $reinitialiser_mot_de_passe->setIdenfUser(uniqid($user->getId()."_",true));
                /*
                    L'utilisation du namespace racine \ permet de préciser que l'on veut utiliser la classe native Datetime. 
                    https://www.developpez.net/forums/d1600285/php/langage/difference-entre-new-datetime-new-datetime/
                */
                $reinitialiser_mot_de_passe->setCreatedAt(new \DateTime());
                //dd(  $reinitialiser_mot_de_passe->getCreatedAt()->format('Y-m-d'));
                $this->entityManager->persist($reinitialiser_mot_de_passe);
                $this->entityManager->flush();

                //Envoie d'un mail a l'utilisateur.
                $url_updatePassword = $this->generateUrl("update_password", [
                    'idenfUser'=>$reinitialiser_mot_de_passe->getIdenfUser()
                ]);
                $mail = new Mail();
                $mail->updatePasswordSend(
                    $user->getEmail(),
                    $user->getUsername(),
                    $user->getFirstname(),
                    $reinitialiser_mot_de_passe->getCreatedAt()->format('Y-m-d'),
                    "<a href= http://127.0.0.1:8000".$url_updatePassword."> Réinitialiser mot de passe </a>"
                );
                
                $this->addFlash(
                    'success',
                    'Votre demande à bien été prise en compte vous allez recevoir dans quelque instant un mail contenant le lien de réinitialisation de votre mot de passe'
                );
                
            }
            //dd($user->getId());
        }

        return $this->render('reset_password/reinitialiser_mot_de_passe.html.twig');
    }

    /**
     *  @Route("/reset/modifier_password/{idenfUser}", name="update_password")    
     */

    public function update($idenfUser, Request $request, UserPasswordEncoderInterface $encoder){
        // recuperer le reset password.
        $reinitialiser_mot_de_passe = $this->entityManager->getRepository(ReinitialiserPassword::class)->findOneByIdenfUser($idenfUser);
        //dd($reinitialiser_mot_de_passe);

        if (!$reinitialiser_mot_de_passe) {
            $this->redirectToRoute('reset_password');
        }

        /*
            Vérifier de l'utilisateur est toujours dans la fourchette de temps pour modifier son mot de passe 
            public DateTime::modify(string $modifier): DateTime|false

            https://www.php.net/manual/fr/datetime.modify.php
        */


        //dd($request->get('old_password'));
        $data_form = [];
        if ($request->getMethod() == 'POST') {
            $data_form['newPsw'] = $request->get('new_password');
            $data_form['comfirmNewPsw'] = $request->get('comfirm_new_password');

            if ($data_form['newPsw'] === $data_form['comfirmNewPsw']) {
                $newPsw = $data_form['newPsw'];
                $userAsk = $reinitialiser_mot_de_passe->getUser();
                $password = $encoder->encodePassword($userAsk, $newPsw);
                $userAsk->setPassword($password);

                $this->entityManager->flush();

                $this->addFlash('notif-success','Votre mot de passe à bien été mis a jour');

                $mail = new Mail;
                $mail->confirmUpdatePasswordSend(
                    $userAsk->getEmail(),
                    $userAsk->getFirstname(),
                    $userAsk->getFirstname(),
                    '<a href="http://127.0.0.1:8000/compte"> sur votre compte </a>'
                );
                
                //dd($userAsk);
            }

        }    
        //dd($data_form);
        return $this->render('reset_password/update.html.twig',[
            'idenfUser' => $idenfUser,
        ]);
       

        //dd($reinitialiser_mot_de_passe);
        //dd($idenfUser);
    }
}

