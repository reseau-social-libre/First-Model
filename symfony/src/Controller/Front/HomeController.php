<?php

namespace App\Controller\Front;

use App\Entity\UserRelationShip;
use App\Manager\FriendShipManager;
use App\Manager\PostManager;
use App\Manager\UserManager;
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
     * @var FriendShipManager
     */
    protected $friendShipManager;

    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * HomeController constructor.
     *
     * @param PostManager       $postManager
     * @param FriendShipManager $friendShipManager
     * @param UserManager       $userManager
     */
    public function __construct(PostManager $postManager, FriendShipManager $friendShipManager, UserManager $userManager)
    {
        $this->postManager = $postManager;
        $this->friendShipManager = $friendShipManager;
        $this->userManager = $userManager;
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
        $userRelationShip = $this->friendShipManager->setUserRelationShip(
            new UserRelationShip($this->getUser())
        );

        $posts = $this->postManager->getWallPaginated(
            null,
            $page,
            $request->getLocale()
        );

        $nbrUsers = $this->userManager->getTotalActiveUser();

        return $this->render('home/index.html.twig', [
            'posts' => $posts,
            'userRelationShip' => $userRelationShip,
            'nbrUsers' => $nbrUsers,
        ]);
    }

}
