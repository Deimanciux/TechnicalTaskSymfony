<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
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

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $password = $passwordEncoded->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $role = $form['role']->getData();
            $user->setRoles([$role]);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $token = new UsernamePasswordToken($user, $password, 'main', $user->getRoles());
            $tokenStorage->setToken($token);
            $session->set('_security_main', serialize($token));

            if($form['role']->getData() === User::TEACHER_USER) {
                return $this->redirectToRoute('add_project');
            }

            return $this->render('status-page/student-status-page.html.twig');
        }

        return $this->render('register/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}