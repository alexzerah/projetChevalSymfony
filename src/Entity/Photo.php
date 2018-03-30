<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


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
     * @Assert\File(
     *     maxSize = "2M",
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png"},
     *     mimeTypesMessage = "Le fichier choisi ne correspond pas à un fichier valide",
     *     notFoundMessage = "Le fichier n'a pas été trouvé sur le disque",
     *     uploadErrorMessage = "Erreur dans l'upload du fichier"
     * )
     * @Vich\UploadableField(mapping="images", fileNameProperty="photo")
     * @var File
     */
    private $photoFile;

    /**
     * Many Users attends Many .
     * @ORM\ManyToMany(targetEntity="Exhibit", mappedBy="photos", cascade={"persist"})
     */
    private $photoExhibits;

    /**
     * Many Users attends Many parties.
     * @ORM\ManyToMany(targetEntity="Party", mappedBy="photos", cascade={"persist"})
     */
    private $photoParties;

    /**
     * Many Users attends many Weekends.
     * @ORM\ManyToMany(targetEntity="Weekend", mappedBy="photos", cascade={"persist"})
     */
    private $photoWeekends;

    /**
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->photoExhibits = new ArrayCollection();
        $this->photoParties = new ArrayCollection();
        $this->photoWeekends = new ArrayCollection();
        $this->updatedAt = new \DateTime();
    }

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
        if ($photo instanceof UploadedFile) {
            $this->setUpdatedAt(new \DateTime());
        }
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
    public function setPhotoFile(File $photoFile = null)
    {
        $this->photoFile = $photoFile;

        if ($photoFile) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return mixed
     */
    public function getPhotoExhibits()
    {
        return $this->photoExhibits;
    }

    /**
     * @param mixed $photoExhibits
     */
    public function setPhotoExhibits($photoExhibits)
    {
        $this->photoExhibits = $photoExhibits;
    }

    /**
     * @return mixed
     */
    public function getPhotoParties()
    {
        return $this->photoParties;
    }

    /**
     * @param mixed $photoParties
     */
    public function setPhotoParties($photoParties)
    {
        $this->photoParties = $photoParties;
    }

    /**
     * @return mixed
     */
    public function getPhotoWeekends()
    {
        return $this->photoWeekends;
    }

    /**
     * @param mixed $photoWeekends
     */
    public function setPhotoWeekends($photoWeekends)
    {
        $this->photoWeekends = $photoWeekends;
    }

    public function addPhotoParty(Party $party)
    {
        if(!$this->photoParties->contains($party)) {
            $this->photoParties->add($party);
            $party->addPhoto($this);
        }
    }
    public function removePhotoParty(Party $party){
        if ($this->photoParties->contains($party)) {
            $this->photoParties->removeElement($party);
            $party->removePhoto($this);
        }
    }


    public function addPhotoExhibit(Exhibit $exhibit)
    {

        if(!$this->photoExhibits->contains($exhibit)) {
            $this->photoExhibits->add($exhibit);
            $exhibit->addPhoto($this);
        }
    }
    public function removePhotoExhibit(Exhibit $exhibit){
        if ($this->photoExhibits->contains($exhibit)) {
            $this->photoExhibits->removeElement($exhibit);
            $exhibit->removePhoto($this);
        }
    }

    public function addPhotoWeekend(Weekend $weekend)
    {
        if(!$this->photoWeekends->contains($weekend)) {
            $this->photoWeekends->add($weekend);
            $weekend->addPhoto($this);
         }
    }
    public function removePhotoWeekend(Weekend $weekend){
        if ($this->photoWeekends->contains($weekend)) {
            $this->photoWeekends->removeElement($weekend);
            $weekend->removePhoto($this);

        }
    }

}