<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FilterSelectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('field_name')
            ->add('category', ChoiceType::class, [
                'choices' => [
                    new Category('Cat1'),
                    new Category('Cat2'),
                    new Category('Cat3'),
                    new Category('Cat4'),
                ],
                // "name" is a property path, meaning Symfony will look for a public
                // property or a public method like "getName()" to define the input
                // string value that will be submitted by the form
                'choice_value' => function(Category $category) {
                    $array = [];
                    $array = $category->getName();
                    dd($array);
                    return ;
                },
                // a callback to return the label for a given choice
                // if a placeholder is used, its empty value (null) may be passed but
                // its label is defined by its own "placeholder" option
                'choice_label' => function(?Category $category) {
                    return $category ? strtoupper($category->getName()) : '';
                },
                // returns the html attributes for each option input (may be radio/checkbox)
                'choice_attr' => function(?Category $category) {
                    return $category ? ['class' => 'category_'.strtolower($category->getName())] : [];
                },
                // every option can use a string property path or any callable that get
                // passed each choice as argument, but it may not be needed
                'group_by' => function() {
                    // randomly assign things into 2 groups
                    return rand(0, 1) == 1 ? 'Group A' : 'Group B';
                },
                // a callback to return whether a category is preferred
                /*'preferred_choices' => function(?Category $category) {
                    return $category && 100 < $category->getArticleCounts();
                },*/
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
