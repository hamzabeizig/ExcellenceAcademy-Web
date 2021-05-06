<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\CourRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourRepository::class)
 */
class Cour
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the product brochure as a PDF file.")
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $cour;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_cours;
    /**
     * @ORM\ManyToOne(targetEntity=Classe::class , inversedBy="cours")
     * * @ORM\JoinColumn(nullable=false)
     */
    private $classe;
    /**
     * @ORM\ManyToOne(targetEntity=User::class , inversedBy="cours")
     * * @ORM\JoinColumn(nullable=false)
     */
    public $user;
    /**
     * @ORM\ManyToOne(targetEntity=Matiere::class , inversedBy="cours")
     * * @ORM\JoinColumn(nullable=false)
     */
    private $matiere;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }
    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
    public function getCour()
    {
        return $this->cour;
    }

    public function setCour($cour)
    {
        $this->cour = $cour;

        return $this;
    }
    public function getNomCours(): ?string
    {
        return $this->nom_cours;
    }

    public function setNomCours(string $nom_cours): self
    {
        $this->nom_cours = $nom_cours;

        return $this;
    }
}
