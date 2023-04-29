<?php

namespace App\Entity;

use App\Repository\JobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JobRepository::class)
 */
class Job
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="integer")
     */
    private $salary;

    /**
     * @ORM\OneToMany(targetEntity=ResJob::class, mappedBy="job")
     */
    private $resJobs;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="job")
     */
    private $comments;

    public function __construct()
    {
        $this->resJobs = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getSalary(): ?int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * @return Collection<int, ResJob>
     */
    public function getResJobs(): Collection
    {
        return $this->resJobs;
    }

    public function addResJob(ResJob $resJob): self
    {
        if (!$this->resJobs->contains($resJob)) {
            $this->resJobs[] = $resJob;
            $resJob->setJob($this);
        }

        return $this;
    }

    public function removeResJob(ResJob $resJob): self
    {
        if ($this->resJobs->removeElement($resJob)) {
            // set the owning side to null (unless already changed)
            if ($resJob->getJob() === $this) {
                $resJob->setJob(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setJob($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getJob() === $this) {
                $comment->setJob(null);
            }
        }

        return $this;
    }
}
