<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\PostText;
use App\Form\Type\PostTextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PostController
 *
 * @Route("/post")
 */
class PostController extends AbstractController
{

    /**
     * @Route("/text/add", name="post-text-add")
     * @param Request $request
     *
     * @return Response
     */
    public function textAdd(Request $request): Response
    {
        $postText = new PostText();
        $postText->setUser($this->getUser());

        $form = $this->createForm(PostTextType::class, $postText);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($postText);
            $em->flush();

            $this->addFlash('success', 'Post is successfully created.');

            return $this->redirectToRoute('home');
        }

        return $this->render('post/text/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
