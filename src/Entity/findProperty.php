<?php


namespace App\Entity;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class FindProperty
{
    private $nom;

    private $prenom;

    private $rec;

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

    public function getRec(): ?string
    {
        return $this->rec;
    }


    public function setRec(string $rec): self
    {
        $this->rec = $rec;
        return $this;
    }


}