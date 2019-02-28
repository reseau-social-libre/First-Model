<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\PostLike;
use App\Form\Type\PostLikeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class PostLikeController
 */
class PostLikeController extends AbstractController
{

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/likes")
     *
     * @param Request $request
     *
     * @return PostLike|FormInterface
     */
    public function postLikesAction(Request $request)
    {
        $postLike = new PostLike();

        $form = $this->createForm(PostLikeType::class, $postLike);
        $form->submit($request->query->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($postLike);
            $em->flush();

            return $postLike;

        } else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/likes")
     *
     * @param Request $request
     */
    public function removeLikesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $postLike = $em->getRepository(PostLike::class)
            ->findOneBy([
                'post' => $request->get('post'),
                'user' => $request->get('user'),
            ]);

        if (null !== $postLike) {
            $em->remove($postLike);
            $em->flush();
        }
    }

}
