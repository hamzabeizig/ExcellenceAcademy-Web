<?php

namespace App\Entity;

use App\Repository\AssiduiteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AssiduiteRepository::class)
 */
class Assiduite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User" , inversedBy="Assiduite")
     * * @ORM\JoinColumn(name="id_user",nullable=false)
     */
    private $user;




    /**
     * @var \Matiere
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Matiere",inversedBy="Assiduite")
     * @ORM\JoinColumn(name="id_matiere", nullable=false)
     */
    private $matiere;



    /**
     * @ORM\Column(type="date")
     */
    private $date;


    public function getUser(): ?User
    {
        return $this->user;
    }


    public function setUser(?User $user): self
    {
        $this->user = $user;
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

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private $valeur;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(string $valeur): self
    {
        if (($valeur=='A')||($valeur=='P'))
        { $this->valeur = $valeur;}
        else
            $this->valeur = 'A' ;
return $this;
    }
}
