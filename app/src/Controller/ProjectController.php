<?php

namespace App\Controller;
use App\Entity\Group;
use App\Entity\Project;
use App\Form\ProjectType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/project")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("/add", name="add_project")
     */
    public function addProject(Request $request)
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $amountOfGroups = $form['amountOfGroups']->getData();
            $studentsPerGroup = $form['studentsPerGroup']->getData();
            $entityManager = $this->getDoctrine()->getManager();

            for($i = 0; $i < $amountOfGroups; $i++) {
                $group = new Group();
                $group->setTitle("group" . $i);
                $group->setMaxAmountOfStudents($studentsPerGroup);
                $entityManager->persist($group);
                $entityManager->flush();
            }

            $entityManager->persist($project);
            $entityManager->flush();
            return $this->redirectToRoute('index_page');
        }

        return $this->render('forms/projectType.html.twig', [
            'form' => $form->createView()
        ]);
    }
}