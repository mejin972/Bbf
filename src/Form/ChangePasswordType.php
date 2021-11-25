<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'Mon adresse mail'
            ])
            ->add('firstname', TextType::class, [
                'disabled' => true,
                'label' => 'Mon Prénom'
            ])
            ->add('lastname', TextType::class, [
                'disabled' => true,
                'label' => 'Mon Nom'
            ])

            ->add('old_password',PasswordType::class,[ // Definir un password type enleve la vaue par default presente dans l'input.
                'mapped' => false,
                'label' => 'Mon mot de passe actuel',
                'attr' => ['placeholder' => 'Veuillez saisir votre mot de passe actuel']
            ])

            ->add('new_password',RepeatedType::class,[
                // indique que les champs sont de type password
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'La confirmation ne correspond pas au mot de passe donner ',// correspond au message d'error confirm incorect
                'label' => 'Mon nouveau Mot de passe',
                'required' => true,
                'first_options' => [
                    'label' => 'Mon Nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'Veuillez saisir votre nouveau mot de passe'
                        ]
                ],
                'second_options' => [
                    'label' => 'Comfirmer votre nouveau mot de passe',
                    'attr' => [
                        'placeholder' => ' Merci de Confirmer votre nouveau mot de passe'
                    ]
                ]
                /*'attr' => [
                    'placeholder' => 'Votre mot de passe..'
                ]*/ 
            ])

            ->add('submit',SubmitType::class,[
                'label' => 'Mettre a jour',
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
