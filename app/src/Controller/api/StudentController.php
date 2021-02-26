<?php

namespace App\Controller\api;

use App\Entity\Group;
use App\Entity\Project;
use App\Entity\Student;
use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class StudentController extends AbstractController
{
    /**
     * @Route("/student/add", name="api_add_student", methods={"POST"})
     */
    public function addStudent(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $studentRepository = $this->getDoctrine()->getRepository(Student::class);
        $groupRepository = $this->getDoctrine()->getRepository(Group::class);
        $students = $studentRepository->findBy(['fullName' => $data["fullName"]]);

        if ($students != null) {
            return $this->json(['error' => 'User with given full name exists'], Response::HTTP_FORBIDDEN);
        }

        $group = $groupRepository->find($data['group_id']);
        $student = new Student();
        $student->setFullName($data["fullName"]);
        $student->setGroup($group);

        $em = $this->getDoctrine()->getManager();
        $em->persist($student);
        $em->flush();

        return $this->json(["success" => true], Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/project/{id}/students")
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getStudentsByProject(Project $project)
    {
        /**
         * @var StudentRepository $repository
         */
        $repository = $this->getDoctrine()->getRepository(Student::class);
        $students = $repository->findAllStudentsByProject($project);

        return $this->json(
            [
                "data" => array_map(function(Student $student) {
                    return [
                        "fullName" => $student->getFullName(),
                        "group_id" => $student->getGroup()->getId()
                    ];
                }, $students)
            ]
        );
    }
}