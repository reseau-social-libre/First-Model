<?php

declare(strict_types=1);

namespace App\Controller\Front;

use App\Entity\FriendShip;
use App\Entity\Relationship;
use App\Entity\UserCoverPicture;
use App\Entity\UserInfo;
use App\Entity\UserProfilePicture;
use App\Entity\UserRelationShip;
use App\Entity\UserStatus;
use App\Form\Type\UserCoverPictureType;
use App\Form\Type\UserInfoType;
use App\Form\Type\UserProfilePictureType;
use App\Form\Type\UserStatusType;
use App\Manager\PostManager;
use App\Manager\FriendShipManager;
use App\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProfileController
 */
class ProfileController extends AbstractController
{

    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * @var PostManager
     */
    protected $postManager;

    /**
     * @var FriendShipManager
     */
    protected $friendShipManager;

    /**
     * ProfileController constructor.
     *
     * @param UserManager       $userManager
     * @param PostManager       $postManager
     * @param FriendShipManager $friendShipManager
     */
    public function __construct(UserManager $userManager, PostManager $postManager, FriendShipManager $friendShipManager)
    {
        $this->userManager = $userManager;
        $this->postManager = $postManager;
        $this->friendShipManager = $friendShipManager;
    }

    /**
     * Show a user profile.
     *
     * @Route("/profile/{username}",
     *     defaults={"page": "1", "_format"="html"},
     *     methods={"GET", "POST"},
     *     name="profile"
     * )
     * @Route("/profile/{username}/page/{page<[1-9]\d*>}",
     *     defaults={"_format"="html"},
     *     methods={"GET", "POST"},
     *     name="profile_paginated"
     * )
     *
     * @param Request $request
     * @param string  $username
     * @param int     $page
     *
     * @return Response
     */
    public function index(Request $request, string $username, int $page): Response
    {

        // Check if user profile is the current logged in user.
        $user = $this->userManager->checkUserByUsername($username, $this->getUser()->getUsername())
            ? $this->getUser() : $this->userManager->getUserByUsername($username);

        if (null === $user) {
            throw new NotFoundHttpException('Sorry not existing!');
        }

        // Set the user relationShip.
        $userRelationShip = $this->friendShipManager->setUserRelationShip(
            new UserRelationShip($user)
        );
        $userRelationShip->setIsFriendPending($this->friendShipManager->hasFriendPendingRequest($this->getUser(), $user));
        $userRelationShip->setIsRequestMeFriend($this->friendShipManager->hasFriendPendingRequest($user, $this->getUser()));
        $userRelationShip->setIsFriend($this->friendShipManager->isUserMyFriend($this->getUser(), $user));
        $userRelationShip->setIsFollowed($this->friendShipManager->isFollowed($this->getUser(), $user));

        // Get the user paginated user wall.
        $posts = $this->postManager->getWallPaginated($user, $page);

        // Form UserStatus
        $userStatus = new UserStatus();
        $userStatus->setUser($this->getUser());

        $formUserStatus = $this->createForm(UserStatusType::class, $userStatus);
        $formUserStatus->handleRequest($request);

        if ($formUserStatus->isSubmitted() && $formUserStatus->isValid()) {
            $user->addUserStatus($userStatus);
            $this->userManager->saveUser($user);

            $this->addFlash('success', 'Your status is updated.');

            return $this->redirectToRoute('profile', [
                'username' => $this->getUser()->getUsername(),
            ]);
        }

        // Form UserCoverPicture
        $userCoverPicture = new UserCoverPicture();

        $formUserCoverPicture = $this->createForm(UserCoverPictureType::class, $userCoverPicture);
        $formUserCoverPicture->handleRequest($request);

        if ($formUserCoverPicture->isSubmitted() && $formUserCoverPicture->isValid()) {
            $user->addUserCoverPicture($userCoverPicture);
            $this->userManager->saveUser($user);

            $this->addFlash('success', 'Your cover is updated.');

            return $this->redirectToRoute('profile', [
                'username' => $this->getUser()->getUsername(),
            ]);
        }

        // Form UserProfilePicture
        $userProfilePicture = new UserProfilePicture();

        $formUserProfilePicture = $this->createForm(UserProfilePictureType::class, $userProfilePicture);
        $formUserProfilePicture->handleRequest($request);

        if ($formUserProfilePicture->isSubmitted() && $formUserProfilePicture->isValid()) {
            $user->addUserProfilePicture($userProfilePicture);
            $this->userManager->saveUser($user);

            $this->addFlash('success', 'Your profile picture is updated.');

            return $this->redirectToRoute('profile', [
                'username' => $this->getUser()->getUsername(),
            ]);
        }

        // Form UserInfo
        if (null === $userInfo = $user->getUserInfo()) {
            $userInfo = new UserInfo();
            $userInfo->setUser($user);
        }

        $formUserInfo = $this->createForm(UserInfoType::class, $userInfo);
        $formUserInfo->handleRequest($request);

        if ($formUserInfo->isSubmitted() && $formUserInfo->isValid()) {
            $user->setUserInfo($userInfo);
            $this->userManager->saveUser($user);

            $this->addFlash('success', 'Your profile information is updated.');

            return $this->redirectToRoute('profile', [
                'username' => $this->getUser()->getUsername(),
            ]);
        }

        return $this->render('profile/index.html.twig', [
            'formStatus' => $formUserStatus->createView(),
            'formCover' => $formUserCoverPicture->createView(),
            'formProfile' => $formUserProfilePicture->createView(),
            'formInfo' => $formUserInfo->createView(),
            'user' => $user,
            'posts' => $posts,
            'userRelationShip' => $userRelationShip,
        ]);
    }

    public function profileBox()
    {
        $userRelationShip = $this->friendShipManager->setUserRelationShip(
            new UserRelationShip($this->getUser())
        );

        return $this->render('home/block/profile.html.twig', [
                'userRelationShip' => $userRelationShip,
        ]);
    }
}
