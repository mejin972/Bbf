<?php

namespace App\Form;

use App\Entity\Adress;
use App\Entity\Carrier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //dd($options);
        $user = $options['user']; //On recupere l'objet user dans la variable $user.
        $builder
            ->add('addresses', EntityType::class, [
                'label'=> 'Choisissez votre adresse de livraison :',
                'required' => true,
                'class' => Adress::class,
                'choices' =>$user->getAdresses(),
                'multiple'=> false,
                'expanded' => true
            ])

            ->add('Carrier', EntityType::class, [
                'label'=> 'Choisissez votre Transporteur :',
                'required' => true,
                'class' => Carrier::class,
                //'choices' =>$user->getAdresses(),
                'multiple'=> false,
                'expanded' => true
            ])

            ->add('submit',SubmitType::class, [
                'label'=>'Validez ma commande',
                'attr'=>[
                    'class' => ' btn btn-success btn-block mt-4'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'user' => array(),// on set l'objet passer au form dans les options. sans sa ' user ' n'est pas connu.
        ]);
    }
}
