<?php

namespace App\Entity;

use App\Repository\SocietePRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=SocietePRepository::class)
 */
class SocieteP
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="le nom de la société ne peut pas contenir un numéro"
     * )
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\Email(
     * message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $Email;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Type("integer")

     */
    private $NumeroTel;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="le Domaine de la société ne peut pas contenir un numéro"
     * )
     */
    private $Domaine;

    /**
     * @ORM\OneToMany(targetEntity=Stage::class, mappedBy="Societe", orphanRemoval=true)
     */
    private $stages;

    public function __construct()
    {
        $this->stages = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getNumeroTel(): ?int
    {
        return $this->NumeroTel;
    }

    public function setNumeroTel(int $NumeroTel): self
    {
        $this->NumeroTel = $NumeroTel;

        return $this;
    }

    public function getDomaine(): ?string
    {
        return $this->Domaine;
    }

    public function setDomaine(string $Domaine): self
    {
        $this->Domaine = $Domaine;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->setSociete($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getSociete() === $this) {
                $stage->setSociete(null);
            }
        }

        return $this;
    }


}