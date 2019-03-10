<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\FriendShip;
use App\Entity\User;
use App\Manager\FriendShipManager;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class FriendShipController
 */
class FriendShipController extends AbstractFOSRestController
{

    /**
     * @var FriendShipManager
     */
    protected $friendShipManager;

    /**
     * FriendShipController constructor.
     *
     * @param FriendShipManager $friendShipManager
     */
    public function __construct(FriendShipManager $friendShipManager)
    {
        $this->friendShipManager = $friendShipManager;
    }

    /**
     * @Rest\View()
     * @Rest\Post("/friend/request/add")
     *
     * @param Request $request
     */
    public function addFriendAction(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->find($request->request->get('user'));
        $friend = $repo->find($request->request->get('friend'));

        if (null !== $user && null !== $friend) {
            $this->friendShipManager->addFriendShip($user, $friend, FriendShip::TYPE_FRIEND);
        }
    }

    /**
     * @Rest\View()
     * @Rest\Post("/friend/request/cancel")
     *
     * @param Request $request
     */
    public function cancelFriendAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);

        $user = $repo->find($request->request->get('user'));
        $friend = $repo->find($request->request->get('friend'));

        if (null !== $user && null !== $friend) {
            $friendRequest = $this->friendShipManager->getFriendShip($user, $friend, FriendShip::TYPE_FRIEND, false);

            $em->remove($friendRequest);
            $em->flush();
        }
    }

    /**
     * @Rest\View()
     * @Rest\Post("/friend/remove")
     *
     * @param Request $request
     */
    public function removeFriendAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);

        $user = $repo->find($request->request->get('user'));
        $friend = $repo->find($request->request->get('friend'));

        if (null !== $user && null !== $friend) {
            $friendRequest = $this->friendShipManager->getFriendShip($user, $friend, FriendShip::TYPE_FRIEND, true);
            $inverseFriendRequest = $this->friendShipManager->getFriendShip($friend, $user, FriendShip::TYPE_FRIEND, true);

            if (null !== $friendRequest && null !== $inverseFriendRequest) {
                $em->remove($friendRequest);
                $em->remove($inverseFriendRequest);
                $em->flush();
            }
        }
    }

    /**
     * @Rest\View()
     * @Rest\Post("/friend/request/accept")
     *
     * @param Request $request
     */
    public function acceptFriendAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);

        $user = $repo->find($request->request->get('user'));
        $friend = $repo->find($request->request->get('friend'));

        if (null !== $user && null !== $friend) {
            $this->friendShipManager->acceptFriendShip($friend, $user);
        }
    }

    /**
     * @Rest\View()
     * @Rest\Post("/friend/follow")
     *
     * @param Request $request
     */
    public function followFriendAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);

        $user = $repo->find($request->request->get('user'));
        $friend = $repo->find($request->request->get('friend'));

        if (null !== $user && null !== $friend) {
            $this->friendShipManager->addFriendShip($user, $friend, FriendShip::TYPE_FOLLOW);
        }
    }

    /**
     * @Rest\View()
     * @Rest\Post("/friend/unfollow")
     *
     * @param Request $request
     */
    public function unFollowFriendAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);

        $user = $repo->find($request->request->get('user'));
        $friend = $repo->find($request->request->get('friend'));

        if (null !== $user && null !== $friend) {
            $friendShip = $this->friendShipManager->getFriendShip($user, $friend, FriendShip::TYPE_FOLLOW, null);

            $em->remove($friendShip);
            $em->flush();
        }
    }


}