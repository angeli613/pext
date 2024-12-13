<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

class CategoryController extends AbstractController
{
   // #[Route('/category', name: 'app_category')]
   #[Route('/', name: 'homepage')]
   //public function index(): Response
    public function index(Environment $twig, CategoryRepository $categoryRepository):Response
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
		);*/
        return new Response($twig->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll(), 
        ]));
    }
}
