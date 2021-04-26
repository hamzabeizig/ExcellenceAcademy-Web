<?php
namespace App\Entity;

class PropertySearch
{

    private $departement;
    private $nom ;
    public function getNom(): ?string
    {
        return $this->nom;
    }
    public function setNom(string $nom): self
    {
        $this->nom = $nom ;
        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }
    public function setDepartement(string $departement): self
    {
        $this->departement = $departement;
        return $this;
    }
}
