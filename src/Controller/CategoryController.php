<?php

namespace App\Controller;

use App\Entity\Expenses;
use App\Entity\Category;
use App\Form\ExpensesType;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\ExpensesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $totalByCategory = $expensesRepository->getTotalAmountByCategory();
        
        $selectedMonthName = $months[$selectedMonth];

        $cat = new Category();
        $catform = $this->createForm(CategoryType::class, $cat);
        $catform->handleRequest($request);

        if ($catform->isSubmitted() && $catform->isValid()) { 
            $this->entityManager->persist($cat); 
            $this->entityManager->flush(); 
            
            return $this->redirectToRoute('homepage'); 
        } 

        return $this->render('category/index.html.twig', [ 
            'expenses_form' => $form->createView(),
            'category_form' => $catform->createView(), 
            'categories' => $categoryNames, 
            'selectedMonth' => $currentMonth,
            'monthname' => $selectedMonthName, 
            'selectedYear' => $currentYear, 
            'categoryData' => $categoryData,
            'totalAmount' => $totalAmount,
            'expenseList' => $expensesRepository->findAll(),
            'totalByCat' => $totalByCategory,
        ]);
    } 

    #[Route('/expenses/{id}', name: 'update_expense', methods: ['PUT'])] 
    public function updateExpense(Request $request, ExpensesRepository $expensesRepository, $id): JsonResponse { 
        $expense = $expensesRepository->find($id); 
        if (!$expense) { 
            return new JsonResponse(['error' => 'Expense not found'], 404); 
        }
    
        $title = $request->query->get('title');
        $amount = $request->query->get('amount');
        $notes = $request->query->get('notes');
    
        try { 
            $expense->setTitle($title); 
            $expense->setAmount($amount); 
            $expense->setNotes($notes); 
            $this->entityManager->persist($expense); 
            $this->entityManager->flush(); 
             
            return new JsonResponse(['success' => 'Expense updated successfully']); 
        } catch (\Exception $e) { 
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }
    
    #[Route('/expenses/{id}', name: 'delete_expense', methods: ['DELETE'])] 
    public function deleteExpense(ExpensesRepository $expensesRepository, $id): JsonResponse { 
        $expense = $expensesRepository->find($id); 
        if (!$expense) 
            return new JsonResponse(['error' => 'Expense not found'], 404); 
        
        try { 
            $this->entityManager->remove($expense); 
            $this->entityManager->flush(); 
            
            return new JsonResponse(['success' => 'Expense deleted successfully']); 
        } 
        catch (\Exception $e) { 
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }
}
