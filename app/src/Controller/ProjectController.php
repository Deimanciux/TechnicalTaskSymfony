<?php

namespace App\Controller;
use App\Entity\Group;
use App\Entity\Project;
use App\Form\ProjectType;
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
     */
    public function addProject(Request $request)
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $teacher = $this->getUser();
            $entityManager = $this->getDoctrine()->getManager();
            $project = $form->getData();
            $project->setStudentsPerGroup($form['studentsPerGroup']->getData());
            $project->setTeacher($teacher);
            $entityManager->persist($project);

            $amountOfGroups = $form['amountOfGroups']->getData();

            for($i = 1; $i < $amountOfGroups + 1; $i++) {
                $group = new Group();
                $group->setTitle("Group #" . $i);
                $group->setProject($project);
                $project->addGroup($group);
                $entityManager->persist($group);
            }
            $entityManager->flush();

            return $this->redirectToRoute('index_page');
        }

        return $this->render('forms/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}