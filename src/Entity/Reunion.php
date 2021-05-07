<?php

namespace App\Entity;

use App\Repository\ReunionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ReunionRepository::class)
 */
class Reunion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ("Reunions")
     *  @Groups ("Reunion")
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
     * @Groups ("Departments")
     *  @Groups ("Reunions")
     * @Groups ("Reunion")
     */
    private $nom;

    /**
     * @ORM\Column(type="date")
     *
     */
    private $date;

    /**
     * @ORM\Column(type="datetime")
     *  @Groups ("Reunions")
     * @Groups ("Reunion")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime")
     *  @Groups ("Reunions")
     * @Groups ("Reunion")
     */
    private $end;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Departement", inversedBy="reunions")
     * @ORM\JoinColumn(nullable=false)
     *  @Groups ("Reunions")
     */
    private $departement;
    /**
 * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="reunions")
     *  @Groups ("Reunions")
 */
    private $users;





    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups ("Reunions")
     * @Groups ("Reunion")
     */
    private $matiere;


    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups ("Reunions")
     * @Groups ("Reunion")
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
     * @return  Collection|User[]
     */
    public function getUsers()
    {
        return $this->users;
    }
    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }
        return $this;
    }
    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
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
    public function __construct()
    {

    }




}
