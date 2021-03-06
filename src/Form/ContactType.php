<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class,[
                'label' => 'Votre prénom',
                'attr'=> [
                    'placeholder' => 'Entrez votre prénom'
                ]
            ])
            ->add('nom',TextType::class,[
                'label' => 'Votre nom',
                'attr'=> [
                    'placeholder' => 'Entrez votre nom'
                ]
            ])
            ->add('mail',EmailType::class,[
                'label' => 'Votre adresse mail',
                'attr'=> [
                    'placeholder' => 'Entrez votre e-mail'
                ]
            ])
            ->add('contenu',TextareaType::class,[
                'label' => 'Votre message',
                'attr'=> [
                    'placeholder' => 'Entrez votre message'
                ]
            ])
            ->add('submit',SubmitType::class,[
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn-block btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
