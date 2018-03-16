<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SoireeRepository")
 */
class Soiree
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="nomSoiree", type="string")
     */
    private $nomSoiree;

    /**
     * @ORM\Column(name="localisation", type="string")
     */
    private $localisation;

    /**
     * @ORM\Column(name="dateEvent", type="datetime")
     */
    private $dateEvent;

    /**
     * @ORM\Column(name="prix", type="decimal")
     */
    private $prix;

    /**
     * @ORM\Column(name="details", type="text")
     */
    private $details;

    /**
     * @ORM\Column(name="banner", type="string")
     */
    private $banner;

    public function __construct()
    {
        $this->dateEvent = new \DateTime();
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
    public function getNomSoiree()
    {
        return $this->nomSoiree;
    }

    /**
     * @param mixed $nomSoiree
     */
    public function setNomSoiree($nomSoiree)
    {
        $this->nomSoiree = $nomSoiree;
    }

    /**
     * @return mixed
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * @param mixed $localisation
     */
    public function setLocalisation($localisation)
    {
        $this->localisation = $localisation;
    }

    /**
     * @return mixed
     */
    public function getDateEvent()
    {
        return $this->dateEvent;
    }

    /**
     * @param mixed $dateEvent
     */
    public function setDateEvent($dateEvent)
    {
        $this->dateEvent = $dateEvent;
    }

    /**
     * @return mixed
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param mixed $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
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

}
