<?php

declare(strict_types=1);

namespace App\Controller\Front;

use App\Entity\Post;
use App\Entity\PostImage;
use App\Entity\PostLive;
use App\Entity\PostText;
use App\Entity\User;
use App\Form\Type\PostImageType;
use App\Form\Type\PostLiveType;
use App\Form\Type\PostTextType;
use HttpResponse;
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
            'title' => 'form.post.text.add',
        ]);
    }

    /**
     * @Route("/text/edit/{id}", name="post-text-edit")
     *
     * @param Request              $request
     * @param \App\Entity\PostText $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param string $defaultLocale
     *
     */
    public function textEdit(Request $request, PostText $id): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if ($user->getId() == $id->getUser()->getId() || $user->hasRole('ROLE_ADMIN')) {
            $form = $this->createForm(PostTextType::class, $id);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($id);
                $em->flush();

                $this->addFlash('success', 'Post is successfully updated.');

                return $this->redirectToRoute('home');
            }

            return $this->render('post/text/add.html.twig', [
                'form' => $form->createView(),
                'title' => 'form.post.text.edit',
            ]);
        }

        return new Response('', Response::HTTP_FORBIDDEN);
    }

    /**
     * @Route("/image/add", name="post-image-add")
     *
     * @param Request $request
     * @param string  $defaultLocale
     *
     * @return Response
     */
    public function imageAdd(Request $request, string $defaultLocale): Response
    {
        // Get the current locale or default.
        if (null == $locale = $request->getLocale()) {
            $locale = $defaultLocale;
        }

        $postImage = new PostImage();
        $postImage->setUser($this->getUser());
        $postImage->setLocale($locale);

        $form = $this->createForm(PostImageType::class, $postImage);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($postImage);
            $em->flush();

            $this->addFlash('success', 'Post is successfully created.');

            return $this->redirectToRoute('home');
        }

        return $this->render('post/image/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/image/edit/{id}", name="post-image-edit")
     *
     * @param Request               $request
     * @param \App\Entity\PostImage $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param string $defaultLocale
     *
     */
    public function imageEdit(Request $request, PostImage $id): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if ($user->getId() == $id->getUser()->getId() || $user->hasRole('ROLE_ADMIN')) {
            $form = $this->createForm(PostImageType::class, $id);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $images = $id->getImages();

                /** @var \App\Entity\ImagePost $image */
                foreach ($images as $image) {
                    if (null == $image->getDocumentFile() && null == $image->getDocument()) {
                        $id->removeImage($image);
                    }
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($id);
                $em->flush();

                $this->addFlash('success', 'Post is successfully updated.');

                return $this->redirectToRoute('home');
            }

            return $this->render('post/image/edit.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        return new Response('',Response::HTTP_FORBIDDEN);
    }

    /**
     * @Route("/live/add", name="post-live-add")
     *
     * @param Request $request
     * @param string  $defaultLocale
     *
     * @return Response
     */
    public function liveAdd(Request $request, string $defaultLocale): Response
    {
        // Get the current locale or default.
        if (null == $locale = $request->getLocale()) {
            $locale = $defaultLocale;
        }

        $postLive = new PostLive();
        $postLive->setUser($this->getUser());
        $postLive->setLocale($locale);

        $form = $this->createForm(PostLiveType::class, $postLive);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($postLive);
            $em->flush();

            $this->addFlash('success', 'Post is successfully created.');

            return $this->redirectToRoute('home');
        }

        return $this->render('post/live/add.html.twig', [
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
