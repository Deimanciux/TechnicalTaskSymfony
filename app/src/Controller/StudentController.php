<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\Project;
use App\Entity\Student;
use App\Form\StudentType;
use App\Service\StudentRemovalService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Security("is_granted('ROLE_USER')")
 * @Route("/student")
 */
class StudentController extends AbstractController
{
    /**
     * @Route("/add/{id}", name="add_student")
     * @Security("is_granted('add', project)", message="Access denied")
     * @param Request $request
     * @param Project $project
     * @param FlashBagInterface $flashBag
     * @return RedirectResponse|Response
     */
    public function add(Request $request, Project $project, FlashBagInterface $flashBag)
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student, ['project' => $project]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($student->getGroup() !== null && sizeof($student->getGroup()->getStudents()) == $project->getStudentsPerGroup()) {
                $flashBag->add('notice', 'This group is full, choose another one');

                return $this->redirectToRoute('add_student', [
                    'id' => $project->getId()
                ]);
            }

            $student = $form->getData();
            $student->setProject($project);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($student);
            $entityManager->flush();

            return $this->redirectToRoute('status_page', [
                'id' => $project->getId()
            ]);
        }

        return $this->render('forms/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{student}/{group}", name="edit_student")
     * @Security("is_granted('edit', student)", message="Access denied")
     * @param Student $student
     * @param Group $group
     * @return RedirectResponse|Response
     */
    public function edit(Student $student, Group $group)
    {
        $student->setGroup($group);
        $project = $student->getProject();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('status_page', [
            'id' => $project->getId()
        ]);
    }

    /**
     * @Route("/remove/{id}", name="remove_student")
     * @Security("is_granted('delete', student)", message="Access denied")
     * @param Student $student
     * @param FlashBagInterface $flashBag
     * @return RedirectResponse
     */
    public function remove(Student $student, FlashBagInterface $flashBag)
    {
        $project = $student->getProject();
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($student);
        $manager->flush();

        $flashBag->add('success', 'Student was deleted');

        return $this->redirectToRoute('status_page', [
            'id' => $project->getId()
        ]);
    }
}
