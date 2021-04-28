<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClasseRepository::class)
 */
class Classe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_classe;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cour", mappedBy="classe")
     */
    private $cours;

    /**
     * @ORM\Column(type="integer" )
     */
    private $id_emp;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbr_etudiant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_salle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClasse(): ?string
    {
        return $this->nom_classe;
    }

    public function setNomClasse(string $nom_classe): self
    {
        $this->nom_classe = $nom_classe;

        return $this;
    }

    public function getNbrEtudiant(): ?int
    {
        return $this->nbr_etudiant;
    }

    public function setNbrEtudiant(int $nbr_etudiant): self
    {
        $this->nbr_etudiant = $nbr_etudiant;

        return $this;
    }

    public function getNomSalle(): ?string
    {
        return $this->nom_salle;
    }

    public function setNomSalle(string $nom_salle): self
    {
        $this->nom_salle = $nom_salle;

        return $this;
    }
    public function __construct()
    {

        $this->cours=new ArrayCollection();
    }
    /**
     * @return Collection|Cour[]
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }
    public function addCour(Cour $cour): self
    {
        if (!$this->cours->contains($cour)) {
            $this->cours[] = $cour;
            $cour->setClasse($this);
        }
        return $this;
    }
    public function removeCour(Cour $cour): self
    {
        if ($this->cours->contains($cour)) {
            $this->cours->removeElement($cour);
            // set the owning side to null (unless already changed)
            if ($cour->getClasse() === $this) {
                $cour->setClasse(null);
            }
        }
        return $this;
    }
}