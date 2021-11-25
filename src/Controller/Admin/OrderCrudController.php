<?php

namespace App\Controller\Admin;

use App\Classe\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class OrderCrudController extends AbstractCrudController
{

    private $entityManager;
    private $crudUrlGenerator; // va permettre de rediriger une fois que l'action sera terminer.

    public function __construct(EntityManagerInterface $entityManager, CrudUrlGenerator $crudUrlGenerator){
        $this->entityManager = $entityManager;
        $this->crudUrlGenerator = $crudUrlGenerator;
    }

    public function getOrder(AdminContext $context){
        $order = $context->getEntity()->getInstance();
        return $order->getState();
    }
    

    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $iconPreparation = "fas fa-people-carry";
        $iconWaitSending = "fas fa-truck-loading";
        $iconPackSend = "fas fa-truck";
        $updatedPreparation = Action::new('updatedPreparation','Préparation en cours', $iconPreparation)->linkToCrudAction('updatedPreparation')
                                ->displayIf(function (Order $order ){
                                    if ($order->getState() != 2 && $order->getState() != 3 && $order->getState() != 4) {
                                        return $order->getState();
                                    }
                                })
        ;
        $waitSending = Action::new('waitSending',"Commande en attente d'envoie", $iconWaitSending)->linkToCrudAction('waitSending')
                                ->displayIf(function (Order $order ){
                                    if ($order->getState() != 3 && $order->getState()!= 4
                                    ) {
                                        return $order->getState();
                                    }
                                    
                                })
        ;
        $packageSend = Action::new('packageSend', "Commande confier au transporteur", $iconPackSend)->linkToCrudAction('packageSend')
                                ->displayIf(function (Order $order ){
                                    if ($order->getState() != 4){
                                        return $order->getState();
                                    }
                                    
                                })
        ;
        return $actions
            ->add('index', 'detail')
            ->add('detail',$packageSend)
            ->add('detail', $waitSending)
            ->add('detail',$updatedPreparation)
            ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['id' => 'DESC']);
    }

    /**
     * Function qui permet de changer le State() de Order, " Commande en cour de préparation " 
     * Redirige ensuite vers l'idex du Crud.
     */
    public function updatedPreparation(AdminContext $context )//Va permettre de récupérer la commande sur laquelle on est
    {
        $order = $context->getEntity()->getInstance();
        $order->setState(2);
        $this->entityManager->flush();

        //Delivre une notification
        $this->addFlash(
            'notification',
            "<div class='alert alert-success'>
                <p> La commande <strong> ".$order->getReference()." </strong> est en cour de préparation </p>
            </div>",
        );

        //Delivre un mail info statut commande a l'utilisateur.
        $mail = new Mail;
        $mail->statutSend(
            'mejin972@gmail.com',
            $order->getUser()->getFirstname(),
            $order->getUser()->getFirstname(),
            "Votre commande ".$order->getReference()." est en cour de préparation",
            '<a href="http://127.0.0.1:8000/compte"> Voir mes commandes </a>',
        );

        //Création de l'url de redirection
        $url = $this->crudUrlGenerator->build()
                    ->setController(OrderCrudController::class)
                    ->setAction('index') //retour a l'index
                    ->generateUrl();
        
        return $this->redirect($url);
    }

    /**
     * Function qui permet de changer le State() de Order, " Commande en attente d'envoie " 
     * Redirige ensuite vers l'idex du Crud.
     */
    public function waitSending(AdminContext $context )//Va permettre de récupérer la commande sur laquelle on est
    {
        $order = $context->getEntity()->getInstance();
        $order->setState(3);
        $this->entityManager->flush();

        $this->addFlash(
            'notification',
            "<div class='alert alert-success'>
                <p> La commande <strong> ".$order->getReference()." </strong> est prête et est en attente d'être pris en charge par ".$order->getCarrierName()." </p>
            </div>",
        );

        $mail = new Mail;
        $mail->statutSend(
            'mejin972@gmail.com',
            $order->getUser()->getFirstname(),
            $order->getUser()->getFirstname(),
            "Votre commande ".$order->getReference()." est prête et est en attente d'être pris en charge par ".$order->getCarrierName(),
            '<a href="http://127.0.0.1:8000/compte"> Voir mes commandes </a>',
        );

        //Création de l'url de redirection
        $url = $this->crudUrlGenerator->build()
                    ->setController(OrderCrudController::class)
                    ->setAction('index') //retour a l'index
                    ->generateUrl();
        
        return $this->redirect($url);
    }

    /**
     * Function qui permet de changer le State() de Order, " Commande confier au transporteur " 
     * Redirige ensuite vers l'idex du Crud.
     */
    public function packageSend(AdminContext $context )//Va permettre de récupérer la commande sur laquelle on est
    {
        $order = $context->getEntity()->getInstance();
        $order->setState(4);
        $this->entityManager->flush();

        $this->addFlash(
            'notification',
            "<div class='alert alert-success'>
                <p> La commande <strong> ".$order->getReference()." </strong> a bien été remis à <strong> ".$order->getCarrierName()." </strong> </p>
            </div>",
        );

        $mail = new Mail;
        $mail->statutSend(
            'mejin972@gmail.com',
            $order->getUser()->getFirstname(),
            $order->getUser()->getFirstname(),
            "Votre commande ".$order->getReference()." a bien été remis à <strong> ".$order->getCarrierName(),
            '<a href="http://127.0.0.1:8000/compte"> Voir mes commandes </a>',
        );

        //Création de l'url de redirection
        $url = $this->crudUrlGenerator->build()
                    ->setController(OrderCrudController::class)
                    ->setAction('index') //retour a l'index
                    ->generateUrl();
        
        return $this->redirect($url);
    }
  
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateTimeField::new('createdAt', 'Passé le'),
            TextField::new('user.getfullName', 'Utilisateur'),
            MoneyField::new('total')->setCurrency('EUR'),
            TextField::new('carrierName', 'transporteur'),
            MoneyField::new('carrierPrice', 'Frai de port')->setCurrency('EUR'),
            TextEditorField::new('delivery', 'Adresse de la livraison')->onlyOnDetail(), //TextEditorField permet d'interpréter le html.
            //BooleanField::new('isPaid', 'Payer'),
            ChoiceField::new('state')->setChoices([
                'Non payé'=>0,
                'Payée'=>1,
                'Préparation en cours'=>2,
                "En attente d'envoie"=>3,
                'Livraison en cours'=>4,
                //'Livrer'=>5
            ]),
            ArrayField::new('orderDetails' , 'produit achetés')
        ];
    }
    
}
