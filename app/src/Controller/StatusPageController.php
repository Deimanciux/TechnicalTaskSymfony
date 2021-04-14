<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("is_granted('ROLE_USER')")
 */
class StatusPageController extends AbstractController
{
    /**
     * @Route("/project/{id}", name="status_page")
     * @param Project $project
     * @return Response
     */
    public function showProject(Project $project)
    {
        return $this->render('status-page/teacher-status-page.html.twig', [
            'project' => $project
        ]);
    }

//    /**
//     * @Route("/refresh", name="refresh_page")
//     * @param Request $request
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function refresh(Request $request)
//    {
//        $data = json_decode($request->getContent(), true);
//        $project = new Project();
//        $project->setTitle($data["title"]);
//        $project->setStudentsPerGroup($data["studentsPerGroup"]);
//        $project->setGroups($data['groups']);
//
//        return $this->render('status-page/teacher-status-page.html.twig', [
//            'project' => $project[0]
//        ]);
//    }
}
