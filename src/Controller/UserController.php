<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\Location;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository ): Response
    {
        $inf_roles = $this->getUser()->getRoles();
        if (in_array("ROLE_ADMIN", $inf_roles)) {
            return $this->render('user/index.html.twig', [
                'users' => $userRepository->findAll(),
            ]);
        }
        else{
            return $this->redirectToRoute('error');
        }
    }

    #[Route('/new', name: 'user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        if (empty($this->getUser())) {

            $route = $request->attributes->get('_route_params');
            $user = new User();

            $form = $this->createForm(UserType::class, $user );
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $password = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('home');
            }

            return $this->render('user/new.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        }
        else {
            return $this->redirectToRoute('error');
        }
    }

    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user, Request $request): Response
    {
        $route = $request->attributes->get('_route_params');

        if (!empty($this->getUser())) {
            $route = implode(" ",$route);

            if (($this->getUser()->getId() == $route) || (in_array("ROLE_ADMIN", $this->getUser()->getRoles()))) {

                return $this->render('user/show.html.twig', [
                    'user' => $user,
                ]);
            }
            else {
                 return $this->redirectToRoute('error');
            }
        } else {
             return $this->redirectToRoute('error');

        }
    }

    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        if (!empty($this->getUser())) {
        $route = $request->attributes->get('_route_params');
        $inf_roles = $this->getUser()->getRoles();
        $form = $this->createForm(UserType::class, $user,  [
        'role' => $inf_roles,
            ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home');
        }



            $route = implode(" ", $route);

            if (($this->getUser()->getId() == $route) || (in_array("ROLE_ADMIN", $inf_roles))) {

                return $this->render('user/edit.html.twig', [
                    'user' => $user,
                    'form' => $form->createView(),
                ]);}
            else {
                    return $this->redirectToRoute('error');
                }
            } else {
                return $this->redirectToRoute('error');

            }
    }

    #[Route('/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function delete(Request $request, User $user): Response
    {
        if (!empty($this->getUser())) {
            $route = implode(" ", $route);

            if (($this->getUser()->getId() == $route) || (in_array("ROLE_ADMIN", $this->getUser()->getRoles()))) {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
            }
            else {
                return $this->redirectToRoute('error');
            }
        } else {
            return $this->redirectToRoute('error');

        }
    }
}
