<?php

namespace App\Form;

use App\Classe\SearchCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FormCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('recherche', TextType::class,[
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => ' Votre recherche...',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('submit', SubmitType::class,[
                'label' => 'FILTRER',
                'attr' =>[
                    'class' => 'btn btn-info'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            //'data_class' => SearchCategory::class,
            'method' => 'GET', // Les utilisateur pourront partager des liens.
            'crsf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
