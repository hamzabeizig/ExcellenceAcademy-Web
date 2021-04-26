<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DepartementRepository")
 */
class Departement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

/**
* @ORM\Column(type="string", length=255)
* @Assert\Length(
* min = 5,
* max = 30,
* minMessage = "Le nom d'un departement doit comporter au moins {{ limit }} caractères",
* maxMessage = "Le nom d'un departement doit comporter au plus {{ limit }} caractères"
* )
*/
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * * @Assert\Length(
     * min = 5,
     * max = 30,
     * minMessage = "Le nom du chef de departement doit comporter au moins {{ limit }} caractères",
     * maxMessage = "Le nom du chef de departement doit comporter au plus {{ limit }} caractères"
     * )
     */
    private $chef_dep;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reunion", mappedBy="departement")
     */
    private $reunions;
    public function __construct()
    {
        $this->reunions = new ArrayCollection();
        $this->enseignants = new ArrayCollection();
    }

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Enseignant", mappedBy="departement")
     */
    private $enseignants;

    public function __construct2()
    {
        $this->enseignants = new ArrayCollection();
    }
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

    public function getChefDep(): ?string
    {
        return $this->chef_dep;
    }

    public function setChefDep(?string $chef_dep): self
    {
        $this->chef_dep = $chef_dep;

        return $this;
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
            $reunion->setDepartement($this);
        }
        return $this;
    }
    public function removeReunion(Reunion $reunion): self
    {
        if ($this->reunions->contains($reunion)) {
            $this->reunions->removeElement($reunion);
            // set the owning side to null (unless already changed)
            if ($reunion->getDepartement() === $this) {
                $reunion->setDepartement(null);
            }
        }
        return $this;
    }
    /**
     * @return Collection|Enseignant[]
     */
    public function getenseignants(): Collection
    {
        return $this->enseignants;
    }
    public function addEnseignant(Enseignant $enseignant): self
    {
        if (!$this->enseignants->contains($enseignant)) {
            $this->enseignants[] = $enseignant;
            $enseignant->setDepartement($this);
        }
        return $this;
    }
    public function removeEnseignant(Enseignant $enseignant): self
    {
        if ($this->enseignants->contains($enseignant)) {
            $this->enseignants->removeElement($enseignant);
            // set the owning side to null (unless already changed)
            if ($enseignant->getDepartement() === $this) {
                $enseignant->setDepartement(null);
            }
        }
        return $this;
    }

}
