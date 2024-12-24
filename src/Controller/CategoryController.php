<?php

namespace App\Controller;

use App\Entity\Expenses;
use App\Form\ExpensesType;
use App\Repository\CategoryRepository;
use App\Repository\ExpensesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


class CategoryController extends AbstractController {
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine, EntityManagerInterface $entityManager) {
        $this->doctrine = $doctrine;
        $this->entityManager = $entityManager;
    }
    
    #[Route('/', name: 'homepage')]
    public function index(CategoryRepository $categoryRepository, ExpensesRepository $expensesRepository, Request $request):Response {       
        $currentYear = date('Y');
        $currentMonth = date('m');
        
        $expensesRepository = $this->doctrine->getRepository('App\Entity\Expenses');
        $expensesData = $expensesRepository->findByMonthAndYear($currentMonth, $currentYear);

        
        $categories = [];
        $data = [];

        foreach ($expensesData as $expense) { 
            $category = $expense->getCategory(); 
            $categoryName = $category ? $category->getName() : 'No Category'; 
            
            if (!isset($data[$categoryName])) { 
                $data[$categoryName] = 0; 
            } 
            
            $data[$categoryName] += $expense->getAmount(); 
        } 
        
        $categoryNames = array_keys($data); 
        $categoryData = array_values($data); 
        $totalAmount = array_sum($categoryData);
        $expense = new Expenses(); 
        $form = $this->createForm(ExpensesType::class, $expense); 
        $form->handleRequest($request); 
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $this->entityManager->persist($expense); 
            $this->entityManager->flush(); 
            
            return $this->redirectToRoute('homepage'); 
        } 
        
        $selectedMonth = $request->query->get('month', date('m')); 
        $months = [ 
            '01' => 'January', 
            '02' => 'February', 
            '03' => 'March', 
            '04' => 'April', 
            '05' => 'May', 
            '06' => 'June', 
            '07' => 'July', 
            '08' => 'August', 
            '09' => 'September', 
            '10' => 'October', 
            '11' => 'November', 
            '12' => 'December', 
        ]; 
        
        $selectedMonthName = $months[$selectedMonth];
        return $this->render('category/index.html.twig', [ 
            'expenses_form' => $form->createView(), 
            'categories' => $categoryNames, 
            'selectedMonth' => $currentMonth,
            'monthname' => $selectedMonthName, 
            'selectedYear' => $currentYear, 
            'categoryData' => $categoryData,
            'totalAmount' => $totalAmount,
            'expenseList' => $expensesRepository->findAll(),
        ]);
    } 

    #[Route('/expenseslist', name: 'expenseslist')]
    public function show(ExpensesRepository $expensesRepository):Response {
        $expenses = $expensesRepository->findAll();

        return $this->render('category/show.html.twig', [
            'expenses' => $expenses,
        ]);
    }
}
