<?php

namespace App\Controller\Admin;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/dashboard", name="admin_index")
     */
    public function index(PostRepository $postRepository): Response
    {

        return $this->render('admin/index.html.twig', [
            'posts' => $postRepository->findAllByUser($this->getUser()),

        ]);
    }

}
