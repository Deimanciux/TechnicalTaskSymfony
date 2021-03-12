<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\Project;
use App\Form\ProjectType;
use App\Service\ProjectService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Security("is_granted('ROLE_USER')")
 * @Route("/project")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("/add", name="add_project")
     * @param Request $request
     * @param ProjectService $projectService
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     */
    public function addProject(Request $request, ProjectService $projectService)
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $teacher = $this->getUser();
            $entityManager = $this->getDoctrine()->getManager();
            $project->setStudentsPerGroup($form['studentsPerGroup']->getData());
            $project->setTeacher($teacher);
            $entityManager->persist($project);

            $amountOfGroups = $form['amountOfGroups']->getData();
            $projectService->assignGroupsToProject($amountOfGroups, $project);

            $entityManager->flush();

            return $this->redirectToRoute('status_page', [
            'id' => $project->getId()
        ]);
        }

        return $this->render('forms/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}