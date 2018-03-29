<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExhibitRepository")
 * @Vich\Uploadable
 */
class Exhibit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @ORM\Column(name="location", type="string")
     */
    private $location;

    /**
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(name="price", type="decimal")
     */
    private $price = 0;

    /**
     * @ORM\Column(name="details", type="text")
     */
    private $details;

    /**
     * @ORM\Column(name="banner", type="string", nullable=true)
     */
    private $banner;

    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="banner")
     * @var File
     */
    private $bannerFile;

    /** *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     * * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * Many Exhibits have Many Users.
     * @ORM\ManyToMany(targetEntity="User", inversedBy="exhibits", cascade={"persist"})
     */
    private $users;

    /**
     * Many Parties have Many Users.
     * @ORM\ManyToMany(targetEntity="Photo", inversedBy="photoExhibits", cascade={"persist"})
     */
    private $photos;

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->users = $user;
    }

    public function addUser($user)
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser($user)
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }
    }

    public function setBannerFile(File $bannerFile = null)
    {
        $this->bannerFile = $bannerFile;
    }
    public function getBannerFile()
    {
        return $this->bannerFile;
    }

    public function __toString()
    {
        return (string) $this->getName();
    }

    public function __construct()
    {
        /* comment */
        $this->users = new ArrayCollection();
        $this->date = new \DateTime();
    }

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @param mixed $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }

    /**
     * @return mixed
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * @param mixed $banner
     */
    public function setBanner($banner)
    {
        $this->banner = $banner;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * @param mixed $photos
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;
    }

    public function addPhotos($photos)
    {
        if (!$this->photos->contains($photos)) {
            $this->photos->add($photos);
        }
        return $this;
    }

    public function removePhotos($photos)
    {
        if ($this->photos->contains($photos)) {
            $this->photos->removeElement($photos);
        }
    }


}
