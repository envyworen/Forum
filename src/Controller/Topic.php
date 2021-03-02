<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class Topic extends AbstractController
{
    /**
     * @Route("/post", name="post")
     */
    public function post(): Response
    {
        return $this->render('topic/new.html.twig', [

        ]);
    }
    /**
     * @Route("/post/create", name="post_create")
     */
    public function create(): Response {
        // Récupère un manager qui permet de manipuler une entité
        $entityManager = $this->getDoctrine()->getManager();

        // Crée une entité et lui donne des valeurs
        $topic = new Topic();
        $topic->setTitre($_POST['titre']);
        $topic->setCategorie($_POST['categorie']);
        $topic->setQuestion($_POST['question']);
        $topic->setIdUser('1');

        // Indique au manager que l'entité doit être sauvegardée (rendue persistente)
        $entityManager->persist($topic);

        // Demande au manager d'exécuter les requêtes SQL (INSERT INTO ici)
        $entityManager->flush();

        return $this->render('post.html.twig', [
            'chateaux' => [],
            'chateau' => $topic
        ]);
    }


}
