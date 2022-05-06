<?php

namespace App\Controller\Admin\Post;

use App\Entity\Post;
use App\Form\PostFormType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PostController extends AbstractController
{

    /**
     * @Route("/admin/posts/ajouter", name="admin_add_post")
     */
    public function addPost(CategoryRepository $categoryRepository, Request $request, ManagerRegistry $doctrine): Response
    {
        if ($categoryRepository->findAll() == null) {
            $this->addFlash('warning', "Vous ne pouvez pas créer de post sans lui asigner une catégorie");
            $this->addFlash('warning', "Veuillez créer une  catégorie et par la suite un post");
            return $this->redirectToRoute('admin_show_categories');
        }

        $post = new Post();
        $form = $this->createForm(PostFormType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            if (array_key_exists('category', $_POST['post_form'])) {
                $post->setUser($this->getUser());
                $em = $doctrine->getManager();
                $em->persist($form->getData());
                $em->flush();

                $this->addFlash('success', 'Le post a bien été ajouté');

                return $this->redirectToRoute('admin_index');
            } else {
                $this->addFlash('warning', 'Vous devez selectionner au minimum une catégorie');
            }
        }

        return $this->render('/admin/post/add_post.html.twig', [
            'postForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/posts/modifier/{id}", name="admin_edit_post")
     */
    public function editPost(Request $request, Post $post, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(PostFormType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($form->getData());
            $em->flush();
            $this->addFlash('success', 'Le post a bien été modifié');

            return $this->redirectToRoute('admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('/admin/post/edit_post.html.twig', [
            'post' => $post,
            'postForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/posts/supprimer/{id}", name="admin_delete_post")
     */
    public function deletePost(Request $request, Post $post, ManagerRegistry $doctrine): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), (string) $request->request->get('_token'))) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($post);
            $entityManager->flush();

            $this->addFlash('success', 'Le post a bien été supprimé');
        }

        return $this->redirectToRoute('admin_index');
    }
}
