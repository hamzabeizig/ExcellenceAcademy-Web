<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MatiereRepository::class)
 */
class Matiere
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(name="nom_matiere", type="string", nullable=false, length=255)
     * @Assert\NotBlank(message=" le champs coefficient est obligatoire!")
     */
    private $nom_matiere;

    /**
     * @var int
     *
     * @ORM\Column(name="coefficient", type="integer", nullable=false)
     * @Assert\NotBlank(message=" le champs coefficient est obligatoire!")
     */
    private $coefficient;

    /**
     * @var int
     *
     * @ORM\Column(name="volume_h", type="integer", nullable=false)
     * @Assert\NotBlank(message=" le champs volume est obligatoire!")
     */
    private $volume_h;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cour", mappedBy="matiere")
     */
    private $cours;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Matiere", mappedBy="matiere")
     */
    private $notes;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Assiduite",mappedBy="matiere")
     */
    private $assiduite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMatiere(): ?string
    {
        return $this->nom_matiere;
    }

    public function setNomMatiere(string $nom_matiere): self
    {
        $this->nom_matiere = $nom_matiere;

        return $this;
    }

    public function getCoefficient(): ?string
    {
        return $this->coefficient;
    }

    public function setCoefficient(string $coefficient): self
    {
        $this->coefficient = $coefficient;

        return $this;
    }

    public function getVolumeH(): ?string
    {
        return $this->volume_h;
    }

    public function setVolumeH(string $volume_h): self
    {
        $this->volume_h = $volume_h;

        return $this;
    }
    public function __construct()
    {

        $this->cours=new ArrayCollection();
        $this->notes=new ArrayCollection();
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
            $cour->setMatiere($this);
        }
        return $this;
    }
    public function removeCour(Cour $cour): self
    {
        if ($this->cours->contains($cour)) {
            $this->cours->removeElement($cour);
            // set the owning side to null (unless already changed)
            if ($cour->getMatiere() === $this) {
                $cour->setMatiere(null);
            }
        }
        return $this;
    }
    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }
    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setMatiere($this);
        }
        return $this;
    }
    public function removeNote(Note $note): self
    {
        if ($this->notes->contains($note)) {
            $this->notes->removeElement($note);
            // set the owning side to null (unless already changed)
            if ($note->getMatiere() === $this) {
                $note->setMatiere(null);
            }
        }
        return $this;
    }
}
