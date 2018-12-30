<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CatalogueRepository")
 */
class Catalogue
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $urlimg;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Annonces", inversedBy="catalogues")
     */
    private $annonce;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrlimg(): ?string
    {
        return $this->urlimg;
    }

    public function setUrlimg(string $urlimg): self
    {
        $this->urlimg = $urlimg;

        return $this;
    }

    public function getAnnonce(): ?Annonces
    {
        return $this->annonce;
    }

    public function setAnnonce(?Annonces $annonce): self
    {
        $this->annonce = $annonce;

        return $this;
    }
}
