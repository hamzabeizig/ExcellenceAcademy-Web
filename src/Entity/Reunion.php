<?php

namespace App\Entity;

use App\Repository\ReunionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReunionRepository::class)
 */
class Reunion
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
    private $nom;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Departement", inversedBy="reunions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $departement;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $matiere;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $objectif;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $horaire;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }
    public function setDepartement(?Departement $departement): self
    {
        $this->departement = $departement;
        return $this;
    }




    public function getMatiere(): ?string
    {
        return $this->matiere;
    }

    public function setMatiere(string $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getObjectif(): ?string
    {
        return $this->objectif;
    }

    public function setObjectif(string $objectif): self
    {
        $this->objectif = $objectif;

        return $this;
    }

    public function getHoraire(): ?string
    {
        return $this->horaire;
    }

    public function setHoraire(string $horaire): self
    {
        $this->horaire = $horaire;

        return $this;
    }
}
