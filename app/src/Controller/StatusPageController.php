<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StatusPageController extends AbstractController
{
    /**
     * @Route("/", name="index_page")
     */
    public function index()
    {
        return $this->render('status-page/teacher-status-page.html.twig');
    }
}