<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
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
    public $Name;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $DescriptionC;

    /**
     * @ORM\OneToMany(targetEntity=Evenement::class, mappedBy="categorie", orphanRemoval=true)
     */
    private $Events;

    public function __construct()
    {
        $this->Events = new ArrayCollection();
    }





    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDescriptionC(): ?string
    {
        return $this->DescriptionC;
    }

    public function setDescriptionC(string $DescriptionC): self
    {
        $this->DescriptionC = $DescriptionC;

        return $this;
    }

    /**
     * @return Collection|Evenement[]
     */
    public function getEvents(): Collection
    {
        return $this->Events;
    }

    public function addEvent(Evenement $event): self
    {
        if (!$this->Events->contains($event)) {
            $this->Events[] = $event;
            $event->setCategorie($this);
        }

        return $this;
    }

    public function removeEvent(Evenement $event): self
    {
        if ($this->Events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getCategorie() === $this) {
                $event->setCategorie(null);
            }
        }

        return $this;
    }






}