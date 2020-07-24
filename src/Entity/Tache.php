<?php

namespace App\Entity;

use App\Repository\TacheRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TacheRepository::class)
 */
class Tache
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Le libellé ne doit pas dépasser {{ limit }} caractères.",
     *      allowEmptyString = false
     * )
     */
    private $libelle;

    /**
     * @ORM\Column(type="datetime")
     */
    private $heureDebut;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThan(propertyPath="heureDebut", message="L'heure de fin doit être plus grande que l'heure de début")
     */
    private $heureFin;

    /**
     * @ORM\Column(type="integer")
     */
    private $etat;

    /**
     * @ORM\OneToOne(targetEntity=LiaisonTacheUser::class, mappedBy="tache", cascade={"persist", "remove"})
     */
    private $liaisonTacheUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(\DateTimeInterface $heureDebut): self
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heureFin;
    }

    public function setHeureFin(\DateTimeInterface $heureFin): self
    {
        $this->heureFin = $heureFin;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getLiaisonTacheUser(): ?LiaisonTacheUser
    {
        return $this->liaisonTacheUser;
    }

    public function setLiaisonTacheUser(LiaisonTacheUser $liaisonTacheUser): self
    {
        $this->liaisonTacheUser = $liaisonTacheUser;

        // set the owning side of the relation if necessary
        if ($liaisonTacheUser->getTache() !== $this) {
            $liaisonTacheUser->setTache($this);
        }

        return $this;
    }
}
