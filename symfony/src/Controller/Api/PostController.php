<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\PostLive;
use App\Entity\User;
use App\Form\Type\PostLiveType;
use App\Manager\PostManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class PostController
 */
class PostController extends AbstractFOSRestController
{

    /**
     * @var PostManager
     */
    protected $postManager;

    /**
     * PostController constructor.
     *
     * @param PostManager $postManager
     */
    public function __construct(PostManager $postManager)
    {
        $this->postManager = $postManager;
    }

    /**
     * @Rest\View()
     * @Rest\Post("/post/lives")
     *
     * @param Request          $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postLivesAction(Request $request)
    {
        $postLive = new PostLive();
        $locale = $request->getLocale();

        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->find($request->request->get('user'));

        if (null === $user) {
            return new Response(Response::HTTP_NOT_FOUND);
        }

        $postLive->setLocale($locale)
            ->setUser($user);

        $form = $this->createForm(PostLiveType::class, $postLive);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            try {
                $this->postManager->createPostLive($postLive);
                return new Response(Response::HTTP_CREATED);
            } catch (\Exception $e) {
                return new Response(Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            return new Response(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}