<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass="App\Repository\PhotoRepository")
 */
class Photo{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="photo", type="string", nullable=true)
     */
    private $photo;
    /**
     * @Vich\UploadableField(mapping="images", fileNameProperty="photo")
     * @var File
     */
    private $photoFile;

    /**
     * Many Users attends Many .
     * @ORM\ManyToMany(targetEntity="Exhibit", mappedBy="photos", cascade={"persist"})
     */
    private $photoexhibits;

    /**
     * Many Users attends Many parties.
     * @ORM\ManyToMany(targetEntity="Party", mappedBy="photos", cascade={"persist"})
     */
    private $photoparties;

    /**
     * Many Users attends many Weekends.
     * @ORM\ManyToMany(targetEntity="Weekend", mappedBy="photos", cascade={"persist"})
     */
    private $photoweekends;




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
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return File
     */
    public function getPhotoFile()
    {
        return $this->photoFile;
    }

    /**
     * @param File $photoFile
     */
    public function setPhotoFile(File $photoFile)
    {
        $this->photoFile = $photoFile;
    }

    /**
     * @return mixed
     */
    public function getPhotoexhibits()
    {
        return $this->photoexhibits;
    }

    /**
     * @param mixed $photoexhibits
     */
    public function setPhotoexhibits($photoexhibits)
    {
        $this->photoexhibits = $photoexhibits;
    }

    /**
     * @return mixed
     */
    public function getPhotoparties()
    {
        return $this->photoparties;
    }

    /**
     * @param mixed $photoparties
     */
    public function setPhotoparties($photoparties)
    {
        $this->photoparties = $photoparties;
    }

    /**
     * @return mixed
     */
    public function getPhotoweekends()
    {
        return $this->photoweekends;
    }

    /**
     * @param mixed $photoweekends
     */
    public function setPhotoweekends($photoweekends)
    {
        $this->photoweekends = $photoweekends;
    }

}