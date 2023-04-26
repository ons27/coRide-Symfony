<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $text_rec = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Type = null;

  

    

    #[ORM\Column(nullable: true)]
    private ?int $id_user = null;

   

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTextRec(): ?string
    {
        return $this->text_rec;
    }

    public function setTextRec(?string $text_rec): self
    {
        $this->text_rec = $text_rec;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(?string $Type): self
    {
        $this->Type = $Type;

        return $this;
    }

    

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function setIdUser(?int $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }

    
}
