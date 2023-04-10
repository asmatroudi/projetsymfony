<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Gouvernorat
 *
 * @ORM\Table(name="gouvernorat")
 * @ORM\Entity
 */
class Gouvernorat
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_gouver", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idGouver;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_gouver", type="string", length=300, nullable=false)
     * @Assert\NotBlank()
     */
    private $nomGouver;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=300, nullable=false)
     * @Assert\NotBlank()
     */
    private $region;

    public function getIdGouver(): ?int
    {
        return $this->idGouver;
    }

    public function getNomGouver(): ?string
    {
        return $this->nomGouver;
    }

    public function setNomGouver(string $nomGouver): self
    {
        $this->nomGouver = $nomGouver;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function __toString(): string {
        return $this->nomGouver;
    }


}
