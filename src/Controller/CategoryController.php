<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
   // #[Route('/category', name: 'app_category')]
   #[Route('/', name: 'homepage')]
   public function index(): Response
    {
        /*return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);*/
        return new Response(<<<EOF
			<html>
				<body>
					<h1>Personal Expense Tracker</h1>
				</body>
			</html>
			EOF
		);
    }
}
