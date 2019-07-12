<?php

namespace App\Controller;

use App\Entity\PostIt;
use App\Form\PostItType;
use App\Repository\PostItRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post/it")
 */
class PostItController extends AbstractController
{
    /**
     * @Route("/", name="post_it_index", methods={"GET"})
     */
    public function index(PostItRepository $postItRepository): Response
    {
        return $this->render('post_it/index.html.twig', [
            'post_its' => $postItRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="post_it_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $postIt = new PostIt();
        $form = $this->createForm(PostItType::class, $postIt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($postIt);
            $entityManager->flush();

            return $this->redirectToRoute('post_it_index');
        }

        return $this->render('post_it/new.html.twig', [
            'post_it' => $postIt,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_it_show", methods={"GET"})
     */
    public function show(PostIt $postIt): Response
    {
        return $this->render('post_it/show.html.twig', [
            'post_it' => $postIt,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="post_it_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PostIt $postIt): Response
    {
        $form = $this->createForm(PostItType::class, $postIt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_it_index');
        }

        return $this->render('post_it/edit.html.twig', [
            'post_it' => $postIt,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_it_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PostIt $postIt): Response
    {
        if ($this->isCsrfTokenValid('delete'.$postIt->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($postIt);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_it_index');
    }
}
