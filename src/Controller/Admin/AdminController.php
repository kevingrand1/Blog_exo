<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("admin/dashboard", name="admin_dashboard")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("admin/dashboard/ajouter-post", name="admin_add_post")
     */
    public function addPost(): Response
    {
        return $this->render('admin/add_post.html.twig');
    }
}
