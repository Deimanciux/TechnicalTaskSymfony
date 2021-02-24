<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FooController extends AbstractController
{
    /**
     * @Route("/index", name="index_pade")
     */
    public function index()
    {
        return $this->render('status-page/status-page.html.twig');
    }
}