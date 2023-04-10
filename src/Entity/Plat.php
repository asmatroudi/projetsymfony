<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plat
 *
 * @ORM\Table(name="plat")
 * @ORM\Entity
 */
class Plat
{
    /**
     * @var int
     *
     * @ORM\Column(name="idplat", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idplat;

    /**
     * @var string
     *
     * @ORM\Column(name="nomplat", type="string", length=30, nullable=false)
     */
    private $nomplat;

    /**
     * @var string
     *
     * @ORM\Column(name="recette", type="string", length=30, nullable=false)
     */
    private $recette;

    /**
     * @var string
     *
     * @ORM\Column(name="chef", type="string", length=30, nullable=false)
     */
    private $chef;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=30, nullable=false)
     */
    private $region;

    public function getIdplat(): ?int
    {
        return $this->idplat;
    }

    public function getNomplat(): ?string
    {
        return $this->nomplat;
    }

    public function setNomplat(string $nomplat): self
    {
        $this->nomplat = $nomplat;

        return $this;
    }

    public function getRecette(): ?string
    {
        return $this->recette;
    }

    public function setRecette(string $recette): self
    {
        $this->recette = $recette;

        return $this;
    }

    public function getChef(): ?string
    {
        return $this->chef;
    }

    public function setChef(string $chef): self
    {
        $this->chef = $chef;

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


}
