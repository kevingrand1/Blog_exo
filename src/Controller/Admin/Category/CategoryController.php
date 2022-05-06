<?php

namespace App\Controller\Admin\Category;

use App\Entity\Post;
use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/admin/categories")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="admin_show_categories")
     */
    public function showCategory(CategoryRepository $categoryRepository, Request $request, ManagerRegistry $doctrine): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em = $doctrine->getManager();
            $em->persist($form->getData());
            $em->flush();
            $this->addFlash('success', 'La categorie a bien été ajoutée');
        }

        return $this->render('admin/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'categoryForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/modifier/{id}", name="admin_edit_category")
     */
    public function editCategory(Request $request, Category $category, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($form->getData());
            $em->flush();
            $this->addFlash('success', 'La catégorie a bien été modifiée');

            return $this->redirectToRoute('admin_show_categories', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('/admin/category/edit_category.html.twig', [
            'category' => $category,
            'categoryForm' => $form->createView(),
        ]);
    }

}
