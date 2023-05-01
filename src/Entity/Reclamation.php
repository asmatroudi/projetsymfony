<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation", indexes={@ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class Reclamation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_rec", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRec;

    /**
     * @var string
     * @Assert\Length(
     *      min = 20,
     *      max = 400,
     *      minMessage = "La Reclamation doit être de longueur superieur à 20 ",
     *      maxMessage = "La Reclamation doit être de longueur inférieur à 400" )
     * @Assert\NotBlank(message="Reclamation doit être non vide")

     * @ORM\Column(name="Reclamation", type="text", length=65535, nullable=false)
     */
    private $reclamation;

    /**
     * @var bool
     
     * @ORM\Column(name="Traitement", type="boolean", nullable=false)
     */
    private $traitement;

    /**
     * @var string
     * @Assert\NotBlank(message="Sujet doit être non vide")
     * @Assert\Length(
     *      min = 4,
     *      max = 25,
     *      minMessage = "Le sujet doit être de longueur superieur à 4 ",
     *      maxMessage = "Le sujet doit être de longueur inférieur à 25" )
     * @Assert\Regex(
     * 
     *     pattern="/^[a-zA-Z0-9 ]*$/",
     *     message="Le Sujet ne doit pas contenir de caractères spéciaux."
     * )
     * @ORM\Column(name="Sujet", type="string", length=255, nullable=false)
     */
    private $sujet;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateRec", type="date", nullable=false)
     */
    private $daterec;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="iduser")
     * })
     */
    private $idUser;

    public function getIdRec(): ?int
    {
        return $this->idRec;
    }

    public function getReclamation(): ?string
    {
        return $this->reclamation;
    }

    public function setReclamation(string $reclamation): self
    {
        $this->reclamation = $reclamation;

        return $this;
    }

    public function isTraitement(): ?bool
    {
        return $this->traitement;
    }

    public function setTraitement(bool $traitement): self
    {
        $this->traitement = $traitement;

        return $this;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getDaterec(): ?\DateTimeInterface
    {
        return $this->daterec;
    }

    public function setDaterec(\DateTimeInterface $daterec): self
    {
        $this->daterec = $daterec;

        return $this;
    }

    public function getIdUser(): ?Utilisateur
    {
        return $this->idUser;
    }

    public function setIdUser(?Utilisateur $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }
}
