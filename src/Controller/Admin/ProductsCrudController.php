<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class ProductsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Products::class;
    }

    
    public function configureFields(string $pageName): iterable
    {

        return[
            TextField::new('name'),
            SlugField::new('slug')->setTargetFieldName('name'),// permet de dire a symfony et easy admin qu'il faut se basé sur le name pour générer le slug. 
            ImageField::new('illustration')
                ->setBasePath('uploads/creaProduct')
                ->setUploadDir('public/uploads/creaProduct')
                ->setUploadedFileNamePattern('[randomhash],[extension]') // [randomhash] permet de save nos pic avec une chaine de cararctere aleatoire.
                ->setRequired('false'),
            TextField::new('subtittle'),
            TextareaField::new('description'),
            MoneyField::new('price')->setCurrency('EUR'),
            TextField::new('genre'),
            BooleanField::new('aLaUne'),
            AssociationField::new('category')

        ];

        /*return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];*/
    }
    
}
