<?php

declare(strict_types=1);

namespace App\Controller\Front;

use App\Entity\User;
use App\Entity\UserCoverPicture;
use App\Entity\UserInfo;
use App\Entity\UserProfilePicture;
use App\Entity\UserStatus;
use App\Form\Type\UserCoverPictureType;
use App\Form\Type\UserInfoType;
use App\Form\Type\UserProfilePictureType;
use App\Form\Type\UserStatusType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProfileController
 */
class ProfileController extends AbstractController
{

    /**
     * Show a user profile.
     *
     * @Route("/profile/{username}", name="profile")
     *
     * @param Request $request
     * @param string  $username
     *
     * @return Response
     */
    public function index(Request $request, string $username): Response
    {

        // Check if user profile is the current logged in user.
        if ($username == $this->getUser()->getUsername()) {
            $user = $this->getUser();
        } else {
            $userRepository = $this->getDoctrine()->getRepository(User::class);
            $user = $userRepository->findOneBy([
               'username' => $username,
            ]);
        }

        // Form UserStatus
        $userStatus = new UserStatus();
        $userStatus->setUser($this->getUser());

        $formUserStatus = $this->createForm(UserStatusType::class, $userStatus);
        $formUserStatus->handleRequest($request);

        if ($formUserStatus->isSubmitted() && $formUserStatus->isValid()) {
            $user->addUserStatus($userStatus);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

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

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

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

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Your profile picture is updated.');

            return $this->redirectToRoute('profile', [
                'username' => $this->getUser()->getUsername(),
            ]);
        }

        // Form UserInfo
        if (null == $userInfo = $user->getUserInfo()) {
            $userInfo = new UserInfo();
            $userInfo->setUser($user);
        }

        $formUserInfo = $this->createForm(UserInfoType::class, $userInfo);
        $formUserInfo->handleRequest($request);

        if ($formUserInfo->isSubmitted() && $formUserInfo->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userInfo);
            $em->flush();

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
        ]);

    }
}
