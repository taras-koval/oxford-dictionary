<?php

namespace App\Controller\Admin;

use App\Entity\Searches;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\HiddenField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SearchesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Searches::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            HiddenField::new('id'),
            TextField::new('word'),
            IntegerField::new('cnt'),
        ];
    }
}
