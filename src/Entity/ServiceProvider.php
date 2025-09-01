<?php

namespace App\Entity;

use App\Repository\ServiceProviderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceProviderRepository::class)]
class ServiceProvider
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $serviceOffered = null;

    #[ORM\Column(nullable: true)]
    private ?bool $businessTrip = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getServiceOffered(): ?string
    {
        return $this->serviceOffered;
    }

    public function setServiceOffered(string $serviceOffered): static
    {
        $this->serviceOffered = $serviceOffered;

        return $this;
    }

    public function isBusinessTrip(): ?bool
    {
        return $this->businessTrip;
    }

    public function setBusinessTrip(?bool $businessTrip): static
    {
        $this->businessTrip = $businessTrip;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }
}
