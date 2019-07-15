<?php

namespace App\Controller;

use App\Entity\PostIt;
use App\Repository\PostItRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(PostItRepository $postItRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'post_its' => $postItRepository->findAll(),
        ]);
    }
}
