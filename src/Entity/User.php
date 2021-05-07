<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=30)
     * @Groups ("Departments")
     *  @Groups ("Reunions")
     */
    private $user_name;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\Length(
     * min = 8,
     * max = 20,
     * minMessage = "Le mot de passe doit comporter au moins {{ limit }} caractères",
     * maxMessage = "Le mot de pass doit comporter au plus {{ limit }} caractères"
     * )
     */
    private $Mdp;

    /**
     * @ORM\Column(type="date")
     */
    private $date_de_naissance;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $role;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Assiduite", mappedBy="user")
     */
    private $Assiduites;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cour", mappedBy="classe")
     */
    private $cours;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DemConvention", mappedBy="id_user_id")
     */
    private $demconvs;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Evenement", mappedBy="user")
     */
    private $events;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Reunion", mappedBy="users")
     */
    private $reunions;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Departement", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $departement;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Note", mappedBy="user")
     */
    private $notes;

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->user_name;
    }

    public function setUserName(string $user_name): self
    {
        $this->user_name = $user_name;

        return $this;
    }
    public function __construct()
    {
        $this->Assuduites = new ArrayCollection();
        $this->events=new ArrayCollection();
        $this->cours=new ArrayCollection();
        $this->demconvs=new ArrayCollection();
        $this->notes=new ArrayCollection();
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->Mdp;
    }

    public function setMdp(string $Mdp): self
    {
        $this->Mdp = $Mdp;

        return $this;
    }

    public function getDateDeNaissance(): ?\DateTime
    {
        return $this->date_de_naissance;
    }

    public function setDateDeNaissance(\DateTime $date_de_naissance): self
    {
        $this->date_de_naissance = $date_de_naissance;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }
    /**
     * @return Collection|Assiduite[]
     */
    public function getAssiduite(): Collection
    {
        return $this->Assiduites;
    }
    public function addAssiduite(Assiduite $assiduite): self
    {
        if (!$this->Assiduites->contains($assiduite)) {
            $this->Assuduites[] = $assiduite;
            $assiduite->setUser($this);
        }
        return $this;
    }
    public function removeAssiduite(Assiduite $assiduite): self
    {
        if ($this->Assiduites->contains($assiduite)) {
            $this->Assuduites->removeElement($assiduite);
            // set the owning side to null (unless already changed)
            if ($assiduite->getUser() === $this)
            {
                $assiduite->setUser(null);
            }
        }
        return $this;
    }/**
     * @return Collection|Evenement[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }
        public function addEvent(Evenement $evenement): self
    {
        if (!$this->events->contains($evenement)) {
            $this->events[] = $evenement;
            $evenement->setUser($this);
        }
        return $this;
    }
    public function removeEvent(Evenement $evenement): self
    {
        if ($this->events->contains($evenement)) {
            $this->events->removeElement($evenement);
            // set the owning side to null (unless already changed)
            if ($evenement->getUser() === $this)
            {
                $evenement->setUser(null);
            }
        }
        return $this;
    }

    /**
     * @return  Collection|DemConvention[]
     */
    public function getDemconvs()
    {
        return $this->demconvs;
    }
    public function addDemconv(DemConvention $demConvention): self
    {
        if (!$this->demconvs->contains($demConvention)) {
            $this->demconvs[] = $demConvention;
        }
        return $this;
    }
    public function removeDemconv(DemConvention $demConvention): self
    {
        if ($this->demconvs->contains($demConvention)) {
            $this->demconvs->removeElement($demConvention);
        }
        return $this;
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
            $cour->setUser($this);
        }
        return $this;
    }
    public function removeCour(Cour $cour): self
    {
        if ($this->cours->contains($cour)) {
            $this->cours->removeElement($cour);
            // set the owning side to null (unless already changed)
            if ($cour->getUser() === $this) {
                $cour->setUser(null);
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
            $note->setUser($this);
        }
        return $this;
    }
    public function removeNote(Note $note): self
    {
        if ($this->notes->contains($note)) {
            $this->notes->removeElement($note);
            // set the owning side to null (unless already changed)
            if ($note->getUser() === $this) {
                $note->setUser(null);
            }
        }
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
            $reunion->addUser($this);
        }
        return $this;
    }
    public function removeReunion(Reunion $reunion): self
    {
        if ($this->reunions->contains($reunion)) {
            $this->reunions->removeElement($reunion);
            $reunion->removeUser($this);
        }
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

    public function getPrenomNom(): ?string
    {
        return $this->nom." ".$this->prenom;
    }

}