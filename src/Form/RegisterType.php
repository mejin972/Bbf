<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('firstname', TextType::class,[
                'label' => 'Votre Prenom',
                'constraints' => new Length([
                    'min' => 3,
                    'max' =>10,
                    'minMessage' => 'Your first name must be at least {{ limit }} characters long',
                    'maxMessage' => 'Your first name cannot be longer than {{ limit }} characters',
                ]),
                'attr' =>[
                    'placeholder' => 'Prénom..'
                ]
            ])

            ->add('lastname',TextType::class,[
                'label' => 'Votre nom',
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 10,
                    'minMessage' => 'Your first name must be at least {{ limit }} characters long',
                    'maxMessage' => 'Your first name cannot be longer than {{ limit }} characters',
                ]),
                'attr' => [
                    'placeholder' => 'Nom de Famille..'
                ]
            ])

            ->add('email', EmailType::class,[
                'label' => 'Votre E-Mail',
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 20,
                    'minMessage' => 'Your first name must be at least {{ limit }} characters long',
                    'maxMessage' => 'Your first name cannot be longer than {{ limit }} characters',]),
                'attr' => [
                    'placeholder' => 'Adresse Mail..'
                ]
            ])
            /**
             * RepeatedType permet de dire symfony que pour une même propriéte on a besion de générer deux champs différent
             */

            ->add('password',RepeatedType::class,[
                // indique que les champs sont de type password
                'type' => PasswordType::class,
                'invalid_message' => 'La confirmation ne correspond pas au mot de passe donner ',// correspond au message d'error confirm incorect
                'label' => 'Mot de passe',
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => 'Entrez votre mot de passe'
                        ]
                ],
                'second_options' => [
                    'label' => 'Comfirmer votre mot de passe',
                    'attr' => [
                        'placeholder' => 'Confirmer votre mot de passe'
                    ]
                ],
                /*'attr' => [
                    'placeholder' => 'Votre mot de passe..'
                ]*/ 
            ])
            /*->add('password_confirm',PasswordType::class,[
                'label' => 'Confirmer votre mot de passe',
                // 'mapped' permet d'indiquer a symfony que la propriéte ajouter n'est pas presente dans l'entité USER mais uniquament dans le rendu.
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Mot de passe'
                ]
            ])*/

            ->add('submit',SubmitType::class,[
                'label' => 'Validez'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
