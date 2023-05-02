<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Utilisateur
 * @UniqueEntity (fields={"email"},message="ther is already an account with this email")
 * @ORM\Table(name="Utilisateur")
 * @ORM\Entity(repositoryClass=UserRepository::class::class)
 */



class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{

    /**
     * @var int
     *
     * @ORM\Column(name="iduser", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private ?int $iduser = null;

    /**
     * @return int|null
     */
    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    /**
     * @param int|null $iduser
     */
    public function setIduser(?int $iduser): void
    {
        $this->iduser = $iduser;
    }

    /**
     * @ORM\Column(length="180",unique="true")
     * @Assert\Email(message="veuillez tapez une forme valide ")
     */
    private ?string $email = null;


    /**
     * @ORM\Column()
     */
    private array $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column()
     */
    private ?string $password = null;


    /**
     * @ORM\Column(length="255")
     * @Assert\Length(min=8,max=8,minMessage="Veullez tapez un numero valide",maxMessage="Veullez tapez un numero valide")
     */

    private ?string $cin = null;

    /**
     * @ORM\Column(length="255")
     */    private ?string $nom = null;

    /**
     * @ORM\Column(length="255")
     */
    private ?string $prenom = null;

    /**
     * @ORM\Column()
     */    private ?int $age = null;

    /**
     * @ORM\Column(length="255")
     */
    private ?string $adresse = null;

    /**
     * @ORM\Column(length="255")
     */
    private ?string $role = null;

    /**
     * @ORM\Column()
     */
    private ?bool $isBlocked = false;



    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }
    
    public function isBlocked(): bool
    {
        return $this->isBlocked;
    }
    
    public function setIsBlocked(bool $isBlocked): self
    {
        $this->isBlocked = $isBlocked;
    
        // if the user is currently logged in, log them out
        // if ($isBlocked && $this->isActive()) {
        //     $this->setIsActive(false);
        // }
    
        return $this;
    }
}
