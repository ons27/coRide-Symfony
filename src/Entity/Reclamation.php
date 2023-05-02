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
    private ?string $sujet = null;

  

    

    #[ORM\Column(nullable: true)]
    private ?int $id_user = null;

    #[ORM\ManyToOne(inversedBy: 'typeRec')]
    private ?TypeReclamation $typeReclamations = null;

    
    public function __construct()
    {
        $this->typeReclamations = new ArrayCollection();
    }
   

    
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
    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(?string $sujet): self
    {
        $this->sujet = $sujet;

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

    /**
     * @return Collection<int, TypeReclamation>
     */
    public function getTypeReclamations(): Collection
    {
        return $this->typeReclamations;
    }

    public function addTypeReclamation(TypeReclamation $typeReclamation): self
    {
        if (!$this->typeReclamations->contains($typeReclamation)) {
            $this->typeReclamations->add($typeReclamation);
            $typeReclamation->setType_r($this);
        }

        return $this;
    }

    public function removeTypeReclamation(TypeReclamation $typeReclamation): self
    {
        if ($this->typeReclamations->removeElement($typeReclamation)) {
            // set the owning side to null (unless already changed)
            if ($typeReclamation->getType_r() === $this) {
                $typeReclamation->setType_r(null);
            }
        }

        return $this;
    }

    public function getTypeReclamation(): ?TypeReclamation
    {
        return $this->typeReclamation;
    }

    public function setTypeReclamation(?TypeReclamation $typeReclamation): self
    {
        $this->typeReclamation = $typeReclamation;

        return $this;
    }

    
}
