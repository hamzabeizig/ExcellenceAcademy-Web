<?php

namespace App\Entity;

use App\Repository\DemConventionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DemConventionRepository::class)
 */
class DemConvention
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\OneToOne(targetEntity=Stage::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Column(type="integer")
     */
    private $id_stage_id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="demconv")
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Column(type="integer")
     */
    private $id_user_id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $user_name;

    /**
     * @Assert\DateTime
     * @var string A "Y-m-d" formatted value
     * @Assert\GreaterThan("today")
     * @ORM\Column(name="date", type="datetime",options={"default": "CURRENT_TIMESTAMP"})
     */
    public $date;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $etat;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $Email;

    public function __construct()
    {
        $this->id_user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getIdStage(): ?int
    {
        return $this->id_stage_id;
    }

    public function setIdStage(int $id_stage_id): self
    {
        $this->id_stage_id = $id_stage_id;

        return $this;
    }

    public function getIdUser(): ?int
    {
        return $this->id_user_id;
    }

    public function setIdUser(?int $id_user_id): self
    {
        $this->id_user_id = $id_user_id;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

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
}