<?php

namespace App\Entity;

use App\Repository\Enseignant1Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=Enseignant1Repository::class)
 */
class Enseignant1 extends User
{


    /**
     * @ORM\ManyToMany(targetEntity=Reunion::class , mappedBy="enseignants1")
     */
    private $reunions;

    /**
     * @ORM\ManyToOne(targetEntity=departement::class , inversedBy="enseignants1")
     * * @ORM\JoinColumn(nullable=false)
     */
    private $departement;

    public function __construct()
    {
        $this->reunions = new ArrayCollection();
    }



    /**
     * @return Collection|Reunion[]
     */
    public function getReunions(): Collection
    {
        return $this->reunions;
    }

    public function addReunion(Reunion $reunion): self
    {
        if (!$this->reunions->contains($reunion)) {
            $this->reunions[] = $reunion;
        }

        return $this;
    }

    public function removeReunion(Reunion $reunion): self
    {
        $this->reunions->removeElement($reunion);

        return $this;
    }

    public function getDepartement(): ?departement
    {
        return $this->departement;
    }

    public function setDepartement(?departement $departement): self
    {
        $this->departement = $departement;

        return $this;
    }
}
