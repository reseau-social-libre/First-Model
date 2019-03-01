<?php

declare(strict_types=1);

namespace App\Controller\Front;

use App\Entity\Post;
use App\Entity\PostText;
use App\Entity\User;
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
     *
     * @param Request $request
     * @param string  $defaultLocale
     *
     * @return Response
     */
    public function textAdd(Request $request, string $defaultLocale): Response
    {
        // Get the current locale or default.
        if (null == $locale = $request->getLocale()) {
            $locale = $defaultLocale;
        }

        $postText = new PostText();
        $postText->setUser($this->getUser());
        $postText->setLocale($locale);

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

    /**
     * @Route("/remove/{id}", name="post-remove")
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function removePost(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Post::class);

        $post = $repository->find($id);

        /** @var User $user */
        $user = $this->getUser();

        // Check if user is admin or is the post owner and delete post.
        // Then, redirect to the homepage.
        if ($user->hasRole('ROLE_ADMIN') || $user->getId() == $post->getUser()->getId()) {
            if (null !== $post) {
                $em->remove($post);
                $em->flush();
            }
        }

        return $this->redirectToRoute('home');
    }
}
