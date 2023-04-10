<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Hotel
 *
 * @ORM\Table(name="hotel", indexes={@ORM\Index(name="gouvernorat_fk", columns={"gouvernorat"})})
 * @ORM\Entity
 */
class Hotel
{
    /**
     * @var int
     *
     * @ORM\Column(name="idh", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idh;

    /**
     * @var string
     *
     * @ORM\Column(name="nomhotel", type="string", length=300, nullable=false)
     * @Assert\NotBlank()
     */
    private $nomhotel;

    /**
     * @var string
     *
     * @ORM\Column(name="nb_etoile", type="string", length=56, nullable=false)
     * @Assert\NotBlank()
     */
    private $nbEtoile;

    /**
     * @var string
     *
     * @ORM\Column(name="site", type="string", length=7000, nullable=false)
     * @Assert\NotBlank()
     */
    private $site;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $image;

    /**
     * @var \Gouvernorat
     *
     * @ORM\ManyToOne(targetEntity="Gouvernorat")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="gouvernorat", referencedColumnName="id_gouver")
     * })
     * @Assert\NotBlank()
     */
    private $gouvernorat;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer", nullable=false)
     * @Assert\NotBlank()
     */
    private $price;
    
    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getIdh(): ?int
    {
        return $this->idh;
    }

    public function getNomhotel(): ?string
    {
        return $this->nomhotel;
    }

    public function setNomhotel(string $nomhotel): self
    {
        $this->nomhotel = $nomhotel;

        return $this;
    }

    public function getNbEtoile(): ?string
    {
        return $this->nbEtoile;
    }

    public function setNbEtoile(string $nbEtoile): self
    {
        $this->nbEtoile = $nbEtoile;

        return $this;
    }

    public function getSite(): ?string
    {
        return $this->site;
    }

    public function setSite(string $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getGouvernorat(): ?Gouvernorat
    {
        return $this->gouvernorat;
    }

    public function setGouvernorat(?Gouvernorat $gouvernorat): self
    {
        $this->gouvernorat = $gouvernorat;

        return $this;
    }


}
