<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/refresh", name="refresh_page")
     */
    public function refresh(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $project = new Project();
        $project->setTitle($data["title"]);
        $project->setStudentsPerGroup($data["studentsPerGroup"]);
        $project->setGroups($data['groups']);

        return $this->render('status-page/teacher-status-page.html.twig', [
            'project' => $project[0]
        ]);
    }
}