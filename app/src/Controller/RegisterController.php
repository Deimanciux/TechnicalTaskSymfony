<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Form\TeacherType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="user_register")
     */
    public function register(UserPasswordEncoderInterface $passwordEncoded, Request $request, TokenStorageInterface $tokenStorage, SessionInterface $session)
    {
//        if ($this->isGranted('ROLE_USER')) {
//            return $this->redirectToRoute('index_page');
//        }

        $teacher = new Teacher();
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $teacher = $form->getData();
            $password = $passwordEncoded->encodePassword($teacher, $teacher->getPassword());
            $teacher->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($teacher);
            $entityManager->flush();

            $token = new UsernamePasswordToken($teacher, $password, 'main', $teacher->getRoles());
            $tokenStorage->setToken($token);
            $session->set('_security_main', serialize($token));

            return $this->redirectToRoute('add_project');
        }

        return $this->render('register/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}