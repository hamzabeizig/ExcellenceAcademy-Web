<?php

namespace App\Entity;


use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 */
class Note
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *  @Groups("note")
     *
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity=Matiere::class , inversedBy="notes")
     * * @ORM\JoinColumn(nullable=false)
     * @Groups("note")
     * @Groups("not")
     *
     */
    private $matiere;

    /**
     * @ORM\ManyToOne(targetEntity=User::class , inversedBy="notes")
     * * @ORM\JoinColumn(nullable=false)
     *
     * @Groups("note")
     */
    private $user;
    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="notes")
     * @Groups("note")
     */
    private $classe;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *  @Assert\Range( * min = 0, * max = 20,
     * minMessage = "Le note d'un etudiant doit ne peut pas etre inferieur à {{ min }} ",
     * maxMessage = "Le note d'un etudiant doit ne peut pas etre superieur à {{ max }} " * )
     * @Groups("note")
     * @Groups("note1")
     *  @Groups("not")
     */
    private $note;

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

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
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user= $user;

        return $this;
    }


}
