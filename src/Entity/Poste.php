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
    #[Assert\NotBlank(message:"Le champ date de user est obligatoire")]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le nom est au minimum de longuer : {{ limit }} ",
        maxMessage: "Le nom est au maximum de longuer :  {{ limit }} "
    )]
    private ?string $user = null;

    #[ORM\Column(length: 255)]
    private ?string $trajet = null;

    #[ORM\Column(length: 255)]
    private ?string $vehicule = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Le champ prix de user est obligatoire")]
    #[Assert\GreaterThan(
        value: 0,
        message: "Le prix doit etre superieur a : {{ compared_value }}"
    )]
    private ?float $prix = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message:"Le champ date de départ est obligatoire")]
    #[Assert\LessThan(propertyPath:"dateArrive", message:"La date de départ doit être antérieure à la date d'arrivée")]

    private ?\DateTimeInterface $dateDepart = null;

    
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotBlank(message:"Le champ date de départ est obligatoire")]
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
