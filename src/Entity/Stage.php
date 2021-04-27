<?php

namespace App\Entity;

use App\Repository\StageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=StageRepository::class)
 */
class Stage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=30)
     */
    public $Email_Societe;

    /**
     * @ORM\Column(type="string", length=30)
     */
    public $pays;

    /**
     * @Assert\DateTime
     * @ORM\Column(name="date_debut", type="datetime")
     */
    public $date_debut;

    /**
     * @Assert\DateTime
     * @Assert\GreaterThan(propertyPath="date_debut")
     * @ORM\Column(name="date_fin", type="datetime")
     */
    public $date_fin;

    /**

     * @ORM\Column(type="string", length=30)
     */
    public $type_stage;

    /**
     * @ORM\OneToMany(targetEntity=SocieteP::class, mappedBy="stages")
     */
    private $societePs;

    /**
     * @ORM\ManyToOne(targetEntity=SocieteP::class, inversedBy="stages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Societe;

    public function __construct()
    {
        $this->societePs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getEmailSociete(): ?string
    {
        return $this->Email_Societe;
    }

    public function setEmailSociete(string $Email_Societe): self
    {
        $this->Email_Societe = $Email_Societe;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getTypeStage(): ?string
    {
        return $this->type_stage;
    }

    public function setTypeStage(string $type_stage): self
    {
        $this->type_stage = $type_stage;

        return $this;
    }

    public function getSociete(): ?SocieteP
    {
        return $this->Societe;
    }

    public function setSociete(?SocieteP $Societe): self
    {
        $this->Societe = $Societe;

        return $this;
    }


}