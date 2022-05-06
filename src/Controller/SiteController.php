<?php

namespace App\Controller;

use App\SearchBars\SearchData;
use App\Form\SearchDataFormType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SiteController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(PostRepository $postRepository, Request $request): Response
    {
        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchDataFormType::class, $data);
        $form->handleRequest($request);

        $posts = $postRepository->findSearch($data);
        return $this->render('site/index.html.twig', [
            'form' => $form->createView(),
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/post-{id}", name="site_show_post")
     */
    public function showPost(PostRepository $postRepository, Request $request): Response
    {

        return $this->render('site/post.html.twig', [
            'post' => $postRepository->findOneBy(['id' => $request->get('id')])
        ]);
    }
    /**
     * @Route("/categorie-{id}", name="site_show_category")
     */
    public function showCategoriesPosts(PostRepository $postRepository, CategoryRepository $categoryRepository, Request $request)
    {

        return $this->render('site/show_category.html.twig', [
            'category' => $categoryRepository->findOneBy(['id' => $request->get('id')]),
            'posts' => $postRepository->findAllPostsBySlug(['id' => $request->get('id')])
        ]);
    }

    /**
     * @Route("/auteur-{id}", name="site_show_author")
     */
    public function showUsersPosts(PostRepository $postRepository, UserRepository $userRepository, Request $request)
    {
        $user = $userRepository->findOneBy(['id' => $request->get('id')]);

        return $this->render('site/show_author.html.twig', [
            'user' => $user,
            'posts' => $postRepository->findAllByUser($user)
        ]);
    }
}
