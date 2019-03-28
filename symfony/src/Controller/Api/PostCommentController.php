<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Post;
use App\Entity\PostComment;
use App\Form\Type\PostCommentType;
use App\Manager\PostManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class PostCommentController
 */
class PostCommentController extends AbstractFOSRestController
{

    /**
     * @var PostManager
     */
    protected $postManager;

    /**
     * PostCommentController constructor.
     *
     * @param \App\Manager\PostManager $postManager
     */
    public function __construct(PostManager $postManager)
    {
        $this->postManager = $postManager;
    }

    /**
     * @Rest\View()
     * @Rest\Post("/comments")
     *
     * @param Request $request
     *
     * @return Response|FormInterface
     */
    public function postCommentsAction(Request $request)
    {
        $postComment = new PostComment();

        $form = $this->createForm(PostCommentType::class, $postComment);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($postComment);
            $em->flush();

            $templateData = ['comment' => $postComment];

            $view = $this->view($postComment, Response::HTTP_CREATED)
                ->setTemplate('home/block/comment-item.html.twig')
                ->setTemplateVar('comment')
                ->setTemplateData($templateData)
            ;

            return $this->handleView($view);

        } else {
            return $form;
        }
    }

    /**
     * @Rest\View()
     * @Rest\Get("/comments/post/{id}")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function postCommentsNumberAction(Request $request, int $id)
    {
        $post = $this->postManager->getPostById($id);

        $templateData = ['post' => $post];

        $view = $this->view($post, Response::HTTP_OK)
                     ->setTemplate('home/block/post-comment-number.html.twig')
                     ->setTemplateVar('comment')
                     ->setTemplateData($templateData)
        ;

        return $this->handleView($view);
    }
}
