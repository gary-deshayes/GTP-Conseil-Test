<?php

namespace App\Entity;

use App\Repository\LiaisonTacheUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LiaisonTacheUserRepository::class)
 */
class LiaisonTacheUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="liaisonTacheUsers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=Tache::class, inversedBy="liaisonTacheUser", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $tache;

    /**
     * @ORM\Column(type="datetime")
     */
    private $heure_prise;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTache(): ?tache
    {
        return $this->tache;
    }

    public function setTache(tache $tache): self
    {
        $this->tache = $tache;

        return $this;
    }

    public function getHeurePrise(): ?\DateTimeInterface
    {
        return $this->heure_prise;
    }

    public function setHeurePrise(\DateTimeInterface $heure_prise): self
    {
        $this->heure_prise = $heure_prise;

        return $this;
    }
}
