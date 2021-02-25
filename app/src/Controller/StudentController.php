<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\Project;
use App\Entity\Student;
use App\Form\StudentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @return
     */
    public function add(Request $request, Project $project, FlashBagInterface $flashBag)
    {
//        $repository = $this->getDoctrine()->getRepository(Project::class);
//        $project = $repository->find($id);

        $student = new Student();
        $form = $this->createForm(StudentType::class, $student, ['project' => $project]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $group = $form['group']->getData();

            if(sizeof($form['group']->getData()->getStudents()) == $project->getStudentsPerGroup()) {
                $flashBag->add('notice', 'This group is full, choose another one');

                return $this->redirectToRoute('add_student', [
                    'id' => $project->getId()
                ]);
            }

            $student = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($student);
            $entityManager->flush();

            return $this->redirectToRoute('index_page');
        }

        return $this->render('forms/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{student}/{group}", name="edit_student")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     */
    public function edit(Student $student, Group $group)
    {
        $student->setGroup($group);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('index_page');
    }

    /**
     * @Route("/remove/{id}", name="remove_student")
     */
    public function remove(Student $student, FlashBagInterface $flashBag)
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($student);
        $manager->flush();

        $flashBag->add('notice', 'Micro post was deleted');

        return $this->redirectToRoute('index_page');
    }
}
