<?php

namespace App\Controller\Front;

use App\Manager\PostManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 */
class HomeController extends AbstractController
{

    /**
     * @var PostManager
     */
    protected $postManager;

    /**
     * HomeController constructor.
     *
     * @param PostManager $postManager
     */
    public function __construct(PostManager $postManager)
    {
        $this->postManager = $postManager;
    }

    /**
     * @Route("/", defaults={"page": "1", "_format"="html"}, methods={"GET"}, name="home")
     * @Route("/page/{page<[1-9]\d*>}", defaults={"_format"="html"}, methods={"GET"}, name="home_paginated")
     *
     * @param Request $request
     * @param int     $page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, int $page): Response
    {
        $posts = $this->postManager->getWallPaginated(
            null,
            $page,
            $request->getLocale()
        );

        return $this->render('home/index.html.twig', [
            'posts' => $posts,
        ]);
    }

}
