<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SiteController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(PostRepository $postRepository): Response
    {

        return $this->render('site/index.html.twig', [
            'posts' => $postRepository->findAllPostActive()
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
}
