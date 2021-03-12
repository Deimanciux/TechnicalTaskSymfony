<?php

namespace App\Controller;

use App\Entity\Project;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Security("is_granted('ROLE_USER')")
 */
class ProjectsPageController extends AbstractController
{
    /**
    * @Route("/index", name="index_page")
    */
    public function index()
    {
        $teacher = $this->getUser();
        $projectRepository = $this->getDoctrine()->getRepository(Project::class);
        $projects = $projectRepository->findBy(['teacher' => $teacher]);

        return $this->render('projects-page/projects-page.html.twig', [
            'projects' => $projects
        ]);
    }
}