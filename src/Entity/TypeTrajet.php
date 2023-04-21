<?php

namespace App\Entity;

use App\Repository\TypeTrajetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeTrajetRepository::class)]
class TypeTrajet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'typeTrajet', targetEntity: Trajet::class)]
    private Collection $type;

    #[ORM\Column(length: 255)]
    private ?string $typet = null;

    public function __construct()
    {
        $this->type = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getTypet(): ?string
    {
        return $this->typet;
    }

    public function setTypet(string $typet): self
    {
        $this->type = $typet;

        return $this;
    }
    public function __toString()
    {
        return $this->typet;
    }
   



    /**
     * @return Collection<int, Trajet>
     */
    public function getType(): Collection
    {
        return $this->type;
    }
    public function setType(string $Type): self
    {
        $this->typet = $Type;

        return $this;
    }

    public function addType(Trajet $type): self
    {
        if (!$this->type->contains($type)) {
            $this->type->add($type);
            $type->setTypeTrajet($this);
        }

        return $this;
    }

    public function removeType(Trajet $type): self
    {
        if ($this->type->removeElement($type)) {
            // set the owning side to null (unless already changed)
            if ($type->getTypeTrajet() === $this) {
                $type->setTypeTrajet(null);
            }
        }

        return $this;
    }

  
}
