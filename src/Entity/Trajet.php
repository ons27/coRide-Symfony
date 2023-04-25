<?php

namespace App\Entity;

use App\Repository\TrajetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Mime\Message;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;

    

#[ORM\Entity(repositoryClass: TrajetRepository::class)]
class Trajet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le champ est obligatoire")]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "Le depart est au minimum de longuer : {{ limit }} ",
        maxMessage: "Le depart est au maximum de longuer :  {{ limit }} "
    )]
    private ?string $depart = null;    

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Le champ est obligatoire")]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: "La destination est au minimum de longuer : {{ limit }} ",
        maxMessage: "La destination est au maximum de longuer :  {{ limit }} "
    )]
    private ?string $destination = null;


    #[ORM\ManyToOne(inversedBy: 'type')]
    private ?TypeTrajet $typeTrajet = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepart(): ?string
    {
        return $this->depart;
    }

    public function setDepart(string $depart): self
    {
        $this->depart = $depart;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

   

    public function getTypeTrajet(): ?TypeTrajet
    {
        return $this->typeTrajet;
    }

    public function setTypeTrajet(?TypeTrajet $typeTrajet): self
    {
        $this->typeTrajet = $typeTrajet;

        return $this;
    }
}
