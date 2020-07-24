<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Length(
     *      max = 180,
     *      maxMessage = "L'email ne doit pas dépasser {{ limit }} caractères.",
     *      allowEmptyString = false
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Le mot de passe ne doit pas dépasser {{ limit }} caractères.",
     *      allowEmptyString = false
     * )
     */
    private $password_clear;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Le nom ne doit pas dépasser {{ limit }} caractères.",
     *      allowEmptyString = false
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Le prénom ne doit pas dépasser {{ limit }} caractères.",
     *      allowEmptyString = false
     * )
     */
    private $prenom;

    /**
     * @ORM\OneToMany(targetEntity=LiaisonTacheUser::class, mappedBy="user", orphanRemoval=true)
     */
    private $liaisonTacheUsers;

    /**
     * @ORM\OneToMany(targetEntity=HistoriqueConnexion::class, mappedBy="user", orphanRemoval=true)
     */
    private $historiqueConnexions;

    public function __construct()
    {
        $this->liaisonTacheUsers = new ArrayCollection();
        $this->historiqueConnexions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
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

    /**
     * Permet d'avoir le role sous forme lisible
     *
     * @return string
     */
    public function getRolesString(): string
    {
        $array = ["ROLE_ADMIN" => "Administrateur", "ROLE_EMPLOYE" => "Employé"];
        return $array[$this->roles[0]];
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
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
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    /**
     * Get the value of password_clear
     */ 
    public function getPasswordClear(): ?string
    {
        return $this->password_clear;
    }

    /**
     * Set the value of password_clear
     *
     * @return  self
     */ 
    public function setPasswordClear($password_clear)
    {
        $this->password_clear = $password_clear;

        return $this;
    }

    /**
     * @return Collection|LiaisonTacheUser[]
     */
    public function getLiaisonTacheUsers(): Collection
    {
        return $this->liaisonTacheUsers;
    }

    public function addLiaisonTacheUser(LiaisonTacheUser $liaisonTacheUser): self
    {
        if (!$this->liaisonTacheUsers->contains($liaisonTacheUser)) {
            $this->liaisonTacheUsers[] = $liaisonTacheUser;
            $liaisonTacheUser->setUser($this);
        }

        return $this;
    }

    public function removeLiaisonTacheUser(LiaisonTacheUser $liaisonTacheUser): self
    {
        if ($this->liaisonTacheUsers->contains($liaisonTacheUser)) {
            $this->liaisonTacheUsers->removeElement($liaisonTacheUser);
            // set the owning side to null (unless already changed)
            if ($liaisonTacheUser->getUser() === $this) {
                $liaisonTacheUser->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|HistoriqueConnexion[]
     */
    public function getHistoriqueConnexions(): Collection
    {
        return $this->historiqueConnexions;
    }

    public function addHistoriqueConnexion(HistoriqueConnexion $historiqueConnexion): self
    {
        if (!$this->historiqueConnexions->contains($historiqueConnexion)) {
            $this->historiqueConnexions[] = $historiqueConnexion;
            $historiqueConnexion->setUser($this);
        }

        return $this;
    }

    public function removeHistoriqueConnexion(HistoriqueConnexion $historiqueConnexion): self
    {
        if ($this->historiqueConnexions->contains($historiqueConnexion)) {
            $this->historiqueConnexions->removeElement($historiqueConnexion);
            // set the owning side to null (unless already changed)
            if ($historiqueConnexion->getUser() === $this) {
                $historiqueConnexion->setUser(null);
            }
        }

        return $this;
    }
}
