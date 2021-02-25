<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("is_granted('ROLE_USER')")
 */
class StatusPageController extends AbstractController
{
    /**
     * @Route("/index", name="index_page")
     */
    public function index()
    {
        $teacher = $this->getUser();
        $projectRepository = $this->getDoctrine()->getRepository(Project::class);
        $project = $projectRepository->findBy(['teacher' => $teacher]);

        return $this->render('status-page/teacher-status-page.html.twig', [
            'project' => $project[0]
        ]);
    }
}