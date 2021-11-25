<?php

namespace App\Form;

use App\Entity\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Quel nom souhaitez vous donner à votre adresse ?',
                'attr' => [
                    'placeholder' => 'Nom de votre adresse',

                ]
            ])
            ->add('firstname', TextType::class,[
                'label' => 'Votre Prénom',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre prénom',
                ]
            ])
            ->add('lastname', TextType::class,[
                'label' => 'Votre Nom',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre nom',
                ]
            ])
            ->add('company', TextType::class,[
                'label' => 'Quel est le nom de votre company ? (Facultatif)',
                'required' => false,
                'attr' => [
                    'placeholder'=> 'Entrez le nom de votre company',
                    'required' => false,
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Votre adresse',
                'attr' => [
                    'placeholder'=>'Exemple : 8 rue champs dorée..'
                ]
            ])
            ->add('code_postal', TextType::class, [
                'label'=> 'Veuillez saisir votre code postal',
                'attr' => [
                    'placeholder' =>'Exemple : 91270..'
                ]
                ])
            ->add('city', TextType::class, [
                'label' => 'Le nom de votre ville',
                'attr' => [
                    'placeholder' => 'Saisir le nom de votre ville',
                ]
            ])
            ->add('pays', CountryType::class, [
                'label' => 'Pays',
                'attr' => [
                    'placeholder' => 'Votre pays',
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => 'Votre numéro de téléphone',
                'attr' => [
                    'placeholder' => 'Exemple : 0612659234..'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn-block btn-info'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
        ]);
    }
}
