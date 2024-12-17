<?php

namespace App\Controller;

use App\Entity\Expenses;
use App\Form\ExpensesType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

class CategoryController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager, ){}

   // #[Route('/category', name: 'app_category')]
   #[Route('/', name: 'homepage')]
   //public function index(): Response
    public function index(Environment $twig, CategoryRepository $categoryRepository, Request $request):Response
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
       
        $expense = new Expenses(); 
        $form = $this->createForm(ExpensesType::class, $expense); 
        $form->handleRequest($request); 
        // Handle form submission 
        if ($form->isSubmitted() && $form->isValid()) { 
            $this->entityManager->persist($expense); 
            $this->entityManager->flush(); 
            return $this->redirectToRoute('homepage'); 
        }
        return $this->render('category/index.html.twig', [ 
            'expenses_form' => $form->createView(),
            'categories' => $categoryRepository->findAll(), 
        ]);
    } 
}
