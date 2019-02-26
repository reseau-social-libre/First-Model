<?php

namespace App\Controller;

use App\Repository\PostRepository;
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
     * @Route("/", defaults={"page": "1", "_format"="html"}, methods={"GET"}, name="home")
     * @Route("/page/{page<[1-9]\d*>}", defaults={"_format"="html"}, methods={"GET"}, name="home_paginated")
     *
     * @param Request        $request
     * @param int            $page
     * @param PostRepository $postRepository
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, int $page, PostRepository $postRepository): Response
    {
        $locale = $request->getLocale();

        $post = $postRepository->findLatest($locale, $page);

        return $this->render('home/index.html.twig', [
            'posts' => $post,
        ]);
    }
}
