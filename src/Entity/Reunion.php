<?php

namespace App\Entity;

use App\Repository\ReunionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

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
     *  @Assert\Length(
     * min = 5,
     * max = 30,
     * minMessage = "Le nom d'une reunion doit comporter au moins {{ limit }} caractères",
     * maxMessage = "Le nom d'une reunion doit comporter au plus {{ limit }} caractères"
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Departement", inversedBy="reunions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $departement;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Enseignant", inversedBy="reunions")
     */
    private $enseignants;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Enseignant1", inversedBy="reunions")
     */
    private $enseignants1;
    public function __construct()
    {
        $this->enseignants = new ArrayCollection();
    }



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

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
    min = 30,
    max = 90,
    notInRangeMessage = "la durée de la reunion doit etre entre  {{ min }}mn et {{ max }}mn "
    )
     */
    private $duree;



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
    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }
    /**
     * @return  Collection|Enseignant[]
     */
    public function getEnseignants()
    {
        return $this->enseignants;
    }
    public function addEnseignant(Enseignant $enseignant): self
    {
        if (!$this->enseignants->contains($enseignant)) {
            $this->enseignants[] = $enseignant;
        }
        return $this;
    }
    public function removeEnseignant(Enseignant $enseignant): self
    {
        if ($this->enseignants->contains($enseignant)) {
            $this->enseignants->removeElement($enseignant);
        }
        return $this;
    }
    /**
     * @return  Collection|Enseignant1[]
     */
    public function getEnseignants1()
    {
        return $this->enseignants1;
    }
    public function addEnseignant1(Enseignant1 $enseignant1): self
    {
        if (!$this->enseignants1->contains($enseignant1)) {
            $this->enseignants1[] = $enseignant1;
        }
        return $this;
    }
    public function removeEnseignant1(Enseignant1 $enseignant1): self
    {
        if ($this->enseignants1->contains($enseignant1)) {
            $this->enseignants1->removeElement($enseignant1);
        }
        return $this;
    }
    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }




}
