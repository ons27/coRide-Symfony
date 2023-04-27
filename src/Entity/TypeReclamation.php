<?php

namespace App\Entity;

use App\Repository\TypeReclamationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeReclamationRepository::class)]
class TypeReclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'typeReclamation', targetEntity: Reclamation::class)]
    private Collection $typeRec;

    #[ORM\Column(length: 255)]
    public ?string $type_r = null;

    public function __construct()
    {
        $this->typeRec = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function __toString()
    {
        return $this->type_r;
    }
    public function getType_r(): ?string
    {
        return $this->type_r;
    }

    public function setType_r(string $type_r): self
    {
        $this->type_r = $type_r;

        return $this;
    }
    /**
     * @return Collection<int, Reclamation>
     */
    public function getTypeRec(): Collection
    {
        return $this->typeRec;
    }
    public function setTypeRec(string $TypeRec): self
    {
        $this->type_r = $TypeRec;

        return $this;
    }
    public function addTypeRec(Reclamation $typeRec): self
    {
        if (!$this->typeRec->contains($typeRec)) {
            $this->typeRec->add($typeRec);
            $typeRec->setTypeReclamation($this);
        }

        return $this;
    }

    public function removeTypeRec(Reclamation $typeRec): self
    {
        if ($this->typeRec->removeElement($typeRec)) {
            // set the owning side to null (unless already changed)
            if ($typeRec->getTypeReclamation() === $this) {
                $typeRec->setTypeReclamation(null);
            }
        }

        return $this;
    }

   
}
