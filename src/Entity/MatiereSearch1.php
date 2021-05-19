<?php namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
class MatiereSearch1 {
    /** * @ORM\ManyToOne(targetEntity="App\Entity\Matiere") */
    private $matiere;
    public function getMatiere(): ?Matiere
    { return $this->matiere; }
    public function setMatiere(?Matiere $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

}