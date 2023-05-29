<?php

// src/Controller/CategoryController.php

namespace App\Controller;

use App\Form\CategoryType;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('Category/index.html.twig', [
            'categories' => $categories,
        ]);
    }
 /**
 * The controller for the category add form
 * Display the form or deal with it
 */
#[Route('/new', name: 'new')]
public function new(Request $request, CategoryRepository $categoryRepository) : Response
{
    // Create a new Category Object
    $category = new Category();
    // Create the associated Form
    $form = $this->createForm(CategoryType::class, $category);
    // Get data from HTTP request
    $form->handleRequest($request);
    // Was the form submitted ?
    if ($form->isSubmitted()) {
        $categoryRepository->save($category, true);
        // Deal with the submitted data
        // For example : persiste & flush the entity
        // And redirect to a route that display the result
        return $this->redirectToRoute('category_index');
    }

    // Render the form
    return $this->render('Category/new.html.twig', [
        'form' => $form,
    ]);
}

    #[Route('/{categoryName}', name: 'show')]
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {
        $category = $categoryRepository->findOneBy(['name' => $categoryName]);

        if (!$category) {
            throw $this->createNotFoundException('Aucune catégorie du nom "' . $categoryName . '" n\'a été trouvée.');
        }

        $programs = $programRepository->findBy(['category' => $category], ['id' => 'DESC'], 3);

        return $this->render('Category/show.html.twig', [
            'category' => $category,
            'programs' => $programs,
        ]);
    }
   
}
