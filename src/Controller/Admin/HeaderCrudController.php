<?php

namespace App\Controller\Admin;

use App\Entity\Header;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class HeaderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Header::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre du header'),
            TextareaField::new('content' , 'Contenu du header'),
            TextField::new('btn_title', 'Titre du boutton'),
            TextareaField::new('btn_url', 'URL du boutton'),
            ImageField::new('illustration', 'image du header')
                ->setBasePath('uploads/headerImg')
                ->setUploadDir('public/uploads/headerImg    ')
                ->setUploadedFileNamePattern('[randomhash],[extension]') // [randomhash] permet de save nos pic avec une chaine de cararctere aleatoire.
                ->setRequired('false'),
        ];
    }
    
}
