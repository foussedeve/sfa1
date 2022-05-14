<?php

namespace App\Entity;

use App\Repository\HistoriqueConnexionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistoriqueConnexionRepository::class)
 */
class HistoriqueConnexion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateConnexion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresseIp;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateConnexion(): ?\DateTimeInterface
    {
        return $this->dateConnexion;
    }

    public function setDateConnexion(\DateTimeInterface $dateConnexion): self
    {
        $this->dateConnexion = $dateConnexion;

        return $this;
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

    public function getAdresseIp(): ?string
    {
        return $this->adresseIp;
    }

    public function setAdresseIp(string $adresseIp): self
    {
        $this->adresseIp = $adresseIp;

        return $this;
    }
}
