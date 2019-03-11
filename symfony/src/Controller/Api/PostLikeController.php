<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\PostLike;
use App\Form\Type\PostLikeType;
use App\Manager\PostManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class PostLikeController
 */
class PostLikeController extends AbstractFOSRestController
{

    /**
     * @var PostManager
     */
    protected $postManager;

    /**
     * PostLikeController constructor.
     *
     * @param PostManager $postManager
     */
    public function __construct(PostManager $postManager)
    {
        $this->postManager = $postManager;
    }

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
        if ((bool)$request->get('liked')) {
            $postLike = $this->postManager->getPostLike(
                intval($request->request->get('user')),
                intval($request->request->get('post'))
            );

            if (null !== $postLike) {
                $this->postManager->removePostLike($postLike);
            }
        } else {
            $postLike = new PostLike();

            $form = $this->createForm(PostLikeType::class, $postLike);
            $form->submit($request->request->all());

            if ($form->isValid()) {
                $this->postManager->addPostLike($postLike);
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
