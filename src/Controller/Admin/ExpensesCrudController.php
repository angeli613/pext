<?php

namespace App\Controller\Admin;

use App\Entity\Expenses;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class ExpensesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Expenses::class;
    }

    public function configureCrud(Crud $crud): Crud{
        return $crud
            ->setEntityLabelInSingular('Expenses Expense')
            ->setEntityLabelInPlural('Expenses Expenses')
            ->setSearchFields(['title', 'amount', 'category.name'])
            ->setDefaultSort(['date' => 'DESC'])
        ;
    }

    public function configureFilters(Filters $filters): Filters{
        return $filters
            ->add(EntityFilter::new('category'))
        ;
    }

    
    public function configureFields(string $pageName): iterable
    {
        /*return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];*/

        yield AssociationField::new('category');
        yield TextField::new('title');
        yield MoneyField::new('amount')->setCurrency('USD');
        yield TextAreaField::new('notes')
            ->hideOnIndex();
        $date = DateField::new('date')->setFormTypeOptions([
        'years' => range(date('Y'), date('Y') + 5),
        'widget' => 'single_text',
        ]);
        if (Crud::PAGE_EDIT === $pageName)
            yield $date->setFormTypeOption('disabled', true);
         else 
            yield $date;
        
    }
}
