<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Post;
use App\Entity\PostLike;
use App\Form\Type\PostLikeType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class PostLikeController
 */
class PostLikeController extends AbstractFOSRestController
{

    /**
     * @Rest\View()
     * @Rest\Post("/likes")
     *
     * @param Request $request
     *
     * @return \App\Entity\PostLike|null|object|\Symfony\Component\Form\FormInterface
     */
    public function postLikesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ((bool)$request->get('liked')) {

            $postLike = $em->getRepository(PostLike::class)
                           ->findOneBy([
                               'post' => $request->get('post'),
                               'user' => $request->get('user'),
                           ]);

            if (null !== $postLike) {
                $em->remove($postLike);
                $em->flush();
            }
        } else {
            $postLike = new PostLike();

            $form = $this->createForm(PostLikeType::class, $postLike);
            $form->submit($request->request->all());

            if ($form->isValid()) {
                $em->persist($postLike);
                $em->flush();
            } else {
                return $form;
            }
        }

        $post = $postLike->getPost();
        $templateData = ['post' => $post];

        $view = $this->view($post, Response::HTTP_CREATED)
                     ->setTemplate('home/block/like-btn.html.twig')
                     ->setTemplateVar('post')
                     ->setTemplateData($templateData)
        ;

        return $this->handleView($view);
    }

}
