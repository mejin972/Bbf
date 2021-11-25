<?php

namespace App\Form;

use App\Classe\Search;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class,[
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => ' Votre recherche...',
                    'class' => 'form-control-sm'
                ]
            ])

            ->add('categories', EntityType::class,[
                'label' => false,
                'required' => false,
                'class' => Category::class,
                'multiple' => true,
                'expanded' => true,
            ])
            
            
            ->add('submit', SubmitType::class,[
                'label' => 'FILTRER',
                'attr' =>[
                    'class' => 'btn btn-info'
                ]
            ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET', // Les utilisateur pourront partager des liens.
            'crsf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }

}




?>