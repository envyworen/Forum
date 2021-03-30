<?php
namespace App\Controller;

use App\Entity\Topic;
use App\Form\TopicType;
use App\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaticPages extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(TopicRepository $topicRepository): Response
    {


        return $this->render('home.html.twig', [
            'topics' => $topicRepository->findAll(),
        ]);
    }
    /**
     * @Route("/error", name="error")
     */
    public function error(TopicRepository $topicRepository): Response
    {


        return $this->render('error.html.twig', [

        ]);
    }



}