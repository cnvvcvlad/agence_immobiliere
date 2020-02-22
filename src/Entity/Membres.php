<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass="App\Repository\MembresRepository")
 * @UniqueEntity(fields="email", message="L'email que vous avez saisi est déjà utilisé!")
 */
class Membres implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message="L'email renseigné est invalide")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\EqualTo(propertyPath="confirm_mot_de_passe", message="")
     */
    private $mot_de_passe;

    /**
     * @Assert\EqualTo(propertyPath="mot_de_passe", message="Les deux mots de passe doivent être identiques!")
     */
    private $confirm_mot_de_passe;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $localisation;

    /**
     * @ORM\Column(type="datetime",options={"default" : "CURRENT_TIMESTAMP"})
     */
    private $date_inscription;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $role;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->mot_de_passe;
    }

    public function setMotDePasse(string $mot_de_passe): self
    {
        $this->mot_de_passe = $mot_de_passe;

        return $this;
    }

    public function getConfirmMotDePasse(): ?string
    {
        return $this->confirm_mot_de_passe;
    }

    public function setConfirmMotDePasse(string $confirm_mot_de_passe): self
    {
        $this->confirm_mot_de_passe = $confirm_mot_de_passe;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->date_inscription;
    }

    public function setDateInscription(\DateTimeInterface $date_inscription): self
    {
        $this->date_inscription = $date_inscription;

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

    public function eraseCredentials(){}

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): ?string
    {
        return $this->prenom . " " . $this->nom;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function setRoles(array $roles)
    {
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->mot_de_passe;
    }

    public function setPassword(string $password): self
    {
        $this->mot_de_passe = $password;

        return $this;
    }
}
