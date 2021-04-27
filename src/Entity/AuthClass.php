<?php


namespace App\Entity;


class AuthClass
{
    private $email;
    private $mdp;
    private $login;
    private $role;

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
        return $this->mdp;
    }
    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;
        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }
    public function setLogin(string $login): self
    {
        $this->login = $login;
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
}