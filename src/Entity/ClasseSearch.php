<?php namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
class ClasseSearch {
    /** * @ORM\ManyToOne(targetEntity="App\Entity\Classe") */
    private $classe;
    public function getClasse(): ?Classe
    { return $this->classe; }
    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

}