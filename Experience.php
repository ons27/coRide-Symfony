<?php

namespace App\Entity;

use App\Repository\ExperienceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExperienceRepository::class)]
class Experience
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $text = null;

    #[ORM\Column(nullable: true)]
    private ?int $rate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToMany(mappedBy: 'exp', targetEntity: commentaireExp::class)]
    private Collection $listeCommentaires;

    public function __construct()
    {
        $this->listeCommentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(?int $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, commentaireExp>
     */
    public function getListeCommentaires(): Collection
    {
        return $this->listeCommentaires;
    }

    public function addListeCommentaire(commentaireExp $listeCommentaire): self
    {
        if (!$this->listeCommentaires->contains($listeCommentaire)) {
            $this->listeCommentaires->add($listeCommentaire);
            $listeCommentaire->setExp($this);
        }

        return $this;
    }

    public function removeListeCommentaire(commentaireExp $listeCommentaire): self
    {
        if ($this->listeCommentaires->removeElement($listeCommentaire)) {
            // set the owning side to null (unless already changed)
            if ($listeCommentaire->getExp() === $this) {
                $listeCommentaire->setExp(null);
            }
        }

        return $this;
    }
}
