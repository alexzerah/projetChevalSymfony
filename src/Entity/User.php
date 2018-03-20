<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Table(name="app_users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @Vich\Uploadable
 */
class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getisActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=254, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(name="avatar", type="string", nullable=true)
     */
    private $avatar;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="avatar")
     * @var File
     */
    private $avatarFile;

    public function setAvatarFile(File $avatarFile = null)
    {
        $this->avatarFile = $avatarFile;
    }
    public function getAvatarFile()
    {
        return $this->avatarFile;
    }

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(name="is_admin", type="boolean")
     */
    private $isAdmin;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Exhibit;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Party;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Weekend;

    /**
     * @ORM\ManyToMany(targetEntity="Exhibit")
     * @ORM\JoinTable(name="user_exhibit",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="exhibit_id", referencedColumnName="id")}
     *      )
     */
    private $exhibitFollow;

    /**
     * @ORM\ManyToMany(targetEntity="Party")
     * @ORM\JoinTable(name="user_party",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="party_id", referencedColumnName="id")}
     *      )
     */
    private $partyFollow;

    /**
     * @ORM\ManyToMany(targetEntity="Weekend")
     * @ORM\JoinTable(name="user_weekend",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="weekend_id", referencedColumnName="id")}
     *      )
     */
    private $weekendFollow;

    public function __construct()
    {
        $this->isActive = true;
        $this->exhibitFollow = new ArrayCollection();
        $this->partyFollow = new ArrayCollection();
        $this->weekendFollow = new ArrayCollection();
        $this->updatedAt = new \DateTime();
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        $roles = $this->isAdmin;
        $roles = array('ROLE_USER');

        if ($this->isAdmin == true) {
            $roles = array('ROLE_ADMIN');
        }

        return $roles;
    }

    public function setRoles(array $roles)
    {
        $this->isAdmin = $roles;

        // allows for chaining
        return $this;
    }


    public function eraseCredentials()
    {
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,

            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getisAdmin()
    {
        if ($this->isAdmin == true) {
            return true;
    } else {
            return false;
        }
    }

    /**
     * @param mixed $isAdmin
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }

    /**
     * @return mixed
     */
    public function getExhibit()
    {
        return $this->Exhibit;
    }

    /**
     * @param mixed $Exhibit
     */
    public function setExhibit($Exhibit)
    {
        $this->Exhibit = $Exhibit;
    }

    /**
     * @return mixed
     */
    public function getParty()
    {
        return $this->Party;
    }

    /**
     * @param mixed $Party
     */
    public function setParty($Party)
    {
        $this->Party = $Party;
    }

    /**
     * @return mixed
     */
    public function getWeekend()
    {
        return $this->Weekend;
    }

    /**
     * @param mixed $Weekend
     */
    public function setWeekend($Weekend)
    {
        $this->Weekend = $Weekend;
    }

    /**
     * @return mixed
     */
    public function getExhibitFollow()
    {
        return $this->exhibitFollow;
    }

    /**
     * @param mixed $exhibitFollow
     */
    public function setExhibitFollow($exhibitFollow)
    {
        $this->exhibitFollow = $exhibitFollow;
    }

    /**
     * @return mixed
     */
    public function getPartyFollow()
    {
        return $this->partyFollow;
    }

    /**
     * @param mixed $partyFollow
     */
    public function setPartyFollow($partyFollow)
    {
        $this->partyFollow = $partyFollow;
    }

    /**
     * @return mixed
     */
    public function getWeekendFollow()
    {
        return $this->weekendFollow;
    }

    /**
     * @param mixed $weekendFollow
     */
    public function setWeekendFollow($weekendFollow)
    {
        $this->weekendFollow = $weekendFollow;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        if ($avatar instanceof UploadedFile) {
            $this->setUpdatedAt(new \DateTime());
        }
    }

    /**
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

}

