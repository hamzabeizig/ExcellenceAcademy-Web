<?php

namespace App\Entity;

use App\Repository\Enseignant1Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=Enseignant1Repository::class)
 */
class Enseignant1 extends User
{




    public function __construct()
    {

    }





}
