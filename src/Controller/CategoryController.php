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
use Twig\Environment;

class CategoryController extends AbstractController
{
    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine, EntityManagerInterface $entityManager)
    {
        $this->doctrine = $doctrine;
        $this->entityManager = $entityManager;
    }
   // #[Route('/', name: 'homepage')]
   // #[Route('/category', name: 'app_category')]
   #[Route('/', name: 'homepage')]
   //public function index(): Response
    public function index(Environment $twig, CategoryRepository $categoryRepository, ExpensesRepository $expensesRepository, Request $request):Response
    {
        /*return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
        return new Response(<<<EOF
			<html>
				<body>
					<h1>Personal Expense Tracker</h1>
				</body>
			</html>
			EOF
		);
        return new Response($twig->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll(), 

        ]));
        /*$categories = $categoryRepository->findAll(); 
        $data = array_map(function($category) { 
            return [ 
                'name' => $category->getName(), 
            ]; 
        }, $categories); */
       
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
        $expense = new Expenses(); 
        $form = $this->createForm(ExpensesType::class, $expense); 
        $form->handleRequest($request); 
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $this->entityManager->persist($expense); 
            $this->entityManager->flush(); 
            
            return $this->redirectToRoute('homepage'); 
        } 
        
        $selectedMonth = $request->query->get('month', date('m')); 
        return $this->render('category/index.html.twig', [ 
            'expenses_form' => $form->createView(), 
            'categories' => $categoryNames, 
            'selectedMonth' => $currentMonth, 
            'selectedYear' => $currentYear, 
            'categoryData' => $categoryData,
        ]);
    } 
}
