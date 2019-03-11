<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 *
 * @ORM\Entity()
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $posts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserStatus", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $userStatuses;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UserInfo", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $userInfo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserCoverPicture", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $userCoverPictures;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserProfilePicture", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $userProfilePictures;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FriendShip", mappedBy="friend", cascade={"persist", "remove"})
     */
    protected $friends;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FriendShip", mappedBy="friendWithMe", cascade={"persist", "remove"})
     */
    protected $friendsWithMe;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Notification", mappedBy="user", cascade={"persist", "remove"})
     */
    private $notifications;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->posts               = new ArrayCollection();
        $this->userStatuses        = new ArrayCollection();
        $this->userCoverPictures   = new ArrayCollection();
        $this->userProfilePictures = new ArrayCollection();
        $this->friends             = new ArrayCollection();
        $this->friendsWithMe       = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }

    /**
     * Get the posts collection.
     *
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    /**
     * Add a post to the collection.
     *
     * @param Post $post
     *
     * @return User
     */
    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    /**
     * Remove post from the collection.
     *
     * @param Post $post
     *
     * @return User
     */
    public function removePost(Post $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Get the user statuses.
     *
     * @return Collection|UserStatus[]
     */
    public function getUserStatuses(): Collection
    {
        return $this->userStatuses;
    }

    /**
     * Add a user status to the collection.
     *
     * @param UserStatus $userStatus
     *
     * @return User
     */
    public function addUserStatus(UserStatus $userStatus): self
    {
        if (!$this->userStatuses->contains($userStatus)) {
            $this->userStatuses[] = $userStatus;
            $userStatus->setUser($this);
        }

        return $this;
    }

    /**
     * Remove a user status from the collection.
     *
     * @param UserStatus $userStatus
     *
     * @return User
     */
    public function removeUserStatus(UserStatus $userStatus): self
    {
        if ($this->userStatuses->contains($userStatus)) {
            $this->userStatuses->removeElement($userStatus);
            // set the owning side to null (unless already changed)
            if ($userStatus->getUser() === $this) {
                $userStatus->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Get the user info.
     *
     * @return UserInfo|null
     */
    public function getUserInfo(): ?UserInfo
    {
        return $this->userInfo;
    }

    /**
     * Set the user info.
     *
     * @param UserInfo $userInfo
     *
     * @return User
     */
    public function setUserInfo(UserInfo $userInfo): self
    {
        $this->userInfo = $userInfo;

        // set the owning side of the relation if necessary
        if ($this !== $userInfo->getUser()) {
            $userInfo->setUser($this);
        }

        return $this;
    }

    /**
     * Get the user cover pictures collection.
     *
     * @return Collection|UserCoverPicture[]
     */
    public function getUserCoverPictures(): Collection
    {
        return $this->userCoverPictures;
    }

    /**
     * Add a cover picture the collection.
     *
     * @param UserCoverPicture $userCoverPicture
     *
     * @return User
     */
    public function addUserCoverPicture(UserCoverPicture $userCoverPicture): self
    {
        if (!$this->userCoverPictures->contains($userCoverPicture)) {
            $this->userCoverPictures[] = $userCoverPicture;
            $userCoverPicture->setUser($this);
        }

        return $this;
    }

    /**
     * Remove a cover picture from the collection.
     *
     * @param UserCoverPicture $userCoverPicture
     *
     * @return User
     */
    public function removeUserCoverPicture(UserCoverPicture $userCoverPicture): self
    {
        if ($this->userCoverPictures->contains($userCoverPicture)) {
            $this->userCoverPictures->removeElement($userCoverPicture);
            // set the owning side to null (unless already changed)
            if ($userCoverPicture->getUser() === $this) {
                $userCoverPicture->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Get the profile pictures collection.
     *
     * @return Collection|UserProfilePicture[]
     */
    public function getUserProfilePictures(): Collection
    {
        return $this->userProfilePictures;
    }

    /**
     * Add a profile picture to the collection.
     *
     * @param UserProfilePicture $userProfilePicture
     *
     * @return User
     */
    public function addUserProfilePicture(UserProfilePicture $userProfilePicture): self
    {
        if (!$this->userProfilePictures->contains($userProfilePicture)) {
            $this->userProfilePictures[] = $userProfilePicture;
            $userProfilePicture->setUser($this);
        }

        return $this;
    }

    /**
     * Remove a profile picture from the collection.
     *
     * @param \App\Entity\UserProfilePicture $userProfilePicture
     *
     * @return \App\Entity\User
     */
    public function removeUserProfilePicture(UserProfilePicture $userProfilePicture): self
    {
        if ($this->userProfilePictures->contains($userProfilePicture)) {
            $this->userProfilePictures->removeElement($userProfilePicture);
            // set the owning side to null (unless already changed)
            if ($userProfilePicture->getUser() === $this) {
                $userProfilePicture->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FriendShip[]
     */
    public function getFriends(): Collection
    {
        return $this->friends;
    }

    /**
     * @param FriendShip $friend
     *
     * @return User
     */
    public function addFriend(FriendShip $friend): self
    {
        if (!$this->friends->contains($friend)) {
            $this->friends[] = $friend;
            $friend->setFriend($this);
        }

        return $this;
    }

    /**
     * @param FriendShip $friend
     *
     * @return User
     */
    public function removeFriend(FriendShip $friend): self
    {
        if ($this->friends->contains($friend)) {
            $this->friends->removeElement($friend);
            // set the owning side to null (unless already changed)
            if ($friend->getFriend() === $this) {
                $friend->setFriend(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FriendShip[]
     */
    public function getFriendsWithMe(): Collection
    {
        return $this->friendsWithMe;
    }

    /**
     * @param FriendShip $friendWithMe
     *
     * @return User
     */
    public function addFriendWithMe(FriendShip $friendWithMe): self
    {
        if (!$this->friendsWithMe->contains($friendWithMe)) {
            $this->friendsWithMe[] = $friendWithMe;
            $friendWithMe->setFriendWithMe($this);
        }

        return $this;
    }

    /**
     * @param FriendShip $friendWithMe
     *
     * @return User
     */
    public function removeFriendWithMe(FriendShip $friendWithMe): self
    {
        if ($this->friendsWithMe->contains($friendWithMe)) {
            $this->friendsWithMe->removeElement($friendWithMe);
            // set the owning side to null (unless already changed)
            if ($friendWithMe->getFriendWithMe() === $this) {
                $friendWithMe->setFriendWithMe(null);
            }
        }

        return $this;
    }

    /**
     * Get the notifications.
     *
     * @return Collection|Notification[]
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    /**
     * Add notification.
     *
     * @param Notification $notification
     *
     * @return User
     */
    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setUser($this);
        }

        return $this;
    }

    /**
     * Remove notification.
     *
     * @param Notification $notification
     *
     * @return User
     */
    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->contains($notification)) {
            $this->notifications->removeElement($notification);
            // set the owning side to null (unless already changed)
            if ($notification->getUser() === $this) {
                $notification->setUser(null);
            }
        }

        return $this;
    }
}
