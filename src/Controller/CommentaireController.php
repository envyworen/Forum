<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commentaire')]
class CommentaireController extends AbstractController
{
    #[Route('/', name: 'commentaire_index', methods: ['GET'])]
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        if (!empty($this->getUser())) {
            $inf_roles = $this->getUser()->getRoles();

            if (in_array("ROLE_ADMIN", $inf_roles)) {
                return $this->render('commentaire/index.html.twig', [
                    'commentaires' => $commentaireRepository->findAll(),
                ]);
            } else {
                return $this->redirectToRoute('error');
            }
        } else {
            return $this->redirectToRoute('error');
        }

    }

    #[Route('/new', name: 'commentaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        if (!empty($this->getUser())) {
            $inf_roles = $this->getUser()->getRoles();

            if (in_array("ROLE_ADMIN", $inf_roles)) {
                $commentaire = new Commentaire();
                $form = $this->createForm(CommentaireType::class, $commentaire);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($commentaire);
                    $entityManager->flush();

                    return $this->redirectToRoute('commentaire_index');
                }

                return $this->render('commentaire/new.html.twig', [
                    'commentaire' => $commentaire,
                    'form' => $form->createView(),
                ]);
            } else {
                return $this->redirectToRoute('error');
            }
        } else {
            return $this->redirectToRoute('error');
        }
    }

    #[Route('/{id}', name: 'commentaire_show', methods: ['GET'])]
    public function show(Commentaire $commentaire): Response
    {
        if (!empty($this->getUser())) {
            $inf_roles = $this->getUser()->getRoles();

            if (in_array("ROLE_ADMIN", $inf_roles)) {
                return $this->render('commentaire/show.html.twig', [
                    'commentaire' => $commentaire,
                ]);
            } else {
                return $this->redirectToRoute('error');
            }
        } else {
            return $this->redirectToRoute('error');
        }
    }

    #[Route('/{id}/edit', name: 'commentaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commentaire $commentaire): Response
    {
        if (!empty($this->getUser())) {
            $inf_roles = $this->getUser()->getRoles();

            if (in_array("ROLE_ADMIN", $inf_roles)) {
                $form = $this->createForm(CommentaireType::class, $commentaire);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $this->getDoctrine()->getManager()->flush();

                    return $this->redirectToRoute('commentaire_index');
                }

                return $this->render('commentaire/edit.html.twig', [
                    'commentaire' => $commentaire,
                    'form' => $form->createView(),
                ]);
            } else {
                return $this->redirectToRoute('error');
            }
        } else {
            return $this->redirectToRoute('error');
        }

    }

    #[Route('/{id}', name: 'commentaire_delete', methods: ['DELETE'])]
    public function delete(Request $request, Commentaire $commentaire): Response
    {
        if (!empty($this->getUser())) {
            $inf_roles = $this->getUser()->getRoles();

            if (in_array("ROLE_ADMIN", $inf_roles)) {

                if ($this->isCsrfTokenValid('delete' . $commentaire->getId(), $request->request->get('_token'))) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($commentaire);
                    $entityManager->flush();
                }

                return $this->redirectToRoute('commentaire_index');
            } else {
                return $this->redirectToRoute('error');
            }
        } else {
            return $this->redirectToRoute('error');
        }
    }
}
