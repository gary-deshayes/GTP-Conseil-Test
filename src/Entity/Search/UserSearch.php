<?php

namespace App\Entity\Search;

/**
 * Classe pour faire des recherches dans la liste des utilisateurs
 */
class UserSearch
{
    private $nom;

    private $prenom;

    private $roles;

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of roles
     */ 
    public function getRoles(): ?string
    {
        return $this->roles;
    }

    /**
     * Set the value of roles
     *
     * @return  self
     */ 
    public function setRoles(?string $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
}
