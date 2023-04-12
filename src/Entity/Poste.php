<?php

namespace App\Entity;

use App\Repository\PosteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PosteRepository::class)]
class Poste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message:"user name is required")]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "user name must be at least {{ limit }} characters long",
        maxMessage: "user name cannot be longer than {{ limit }} characters"
    )]
    private ?string $user = null;

    #[ORM\Column(length: 255)]
    private ?string $trajet = null;

    #[ORM\Column(length: 255)]
    private ?string $vehicule = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Price is required")]
    #[Assert\GreaterThan(
        value: 0,
        message: "price must be greater than {{ compared_value }}"
    )]
    private ?float $prix = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDepart = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateArrive = null;

    #[ORM\ManyToOne(inversedBy: 'postes')]
    private ?TypePublication $typepost = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTrajet(): ?string
    {
        return $this->trajet;
    }

    public function setTrajet(string $trajet): self
    {
        $this->trajet = $trajet;

        return $this;
    }

    public function getVehicule(): ?string
    {
        return $this->vehicule;
    }

    public function setVehicule(string $vehicule): self
    {
        $this->vehicule = $vehicule;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(\DateTimeInterface $dateDepart): self
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    public function getDateArrive(): ?\DateTimeInterface
    {
        return $this->dateArrive;
    }

    public function setDateArrive(\DateTimeInterface $dateArrive): self
    {
        $this->dateArrive = $dateArrive;

        return $this;
    }

    public function getTypepost(): ?TypePublication
    {
        return $this->typepost;
    }

    public function setTypepost(?TypePublication $typepost): self
    {
        $this->typepost = $typepost;

        return $this;
    }
}
