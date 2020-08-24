<?php

namespace App\Entity;

use App\Repository\LivrableRenduRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LivrableRenduRepository::class)
 */
class LivrableRendu
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statut;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $delai;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateDeRendu;

    /**
     * @ORM\ManyToOne(targetEntity=LivrablesPartiels::class, inversedBy="livrableRendus")
     */
    private $livrablesPartiels;

    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="livrableRendus")
     */
    private $apprenant;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $archivage;

    /**
     * @ORM\OneToMany(targetEntity=Commentaires::class, mappedBy="LivrableRendu")
     */
    private $commentaires;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDelai(): ?\DateTimeInterface
    {
        return $this->delai;
    }

    public function setDelai(?\DateTimeInterface $delai): self
    {
        $this->delai = $delai;

        return $this;
    }

    public function getDateDeRendu(): ?\DateTimeInterface
    {
        return $this->dateDeRendu;
    }

    public function setDateDeRendu(?\DateTimeInterface $dateDeRendu): self
    {
        $this->dateDeRendu = $dateDeRendu;

        return $this;
    }

    public function getLivrablesPartiels(): ?LivrablesPartiels
    {
        return $this->livrablesPartiels;
    }

    public function setLivrablesPartiels(?LivrablesPartiels $livrablesPartiels): self
    {
        $this->livrablesPartiels = $livrablesPartiels;

        return $this;
    }

    public function getApprenant(): ?Apprenant
    {
        return $this->apprenant;
    }

    public function setApprenant(?Apprenant $apprenant): self
    {
        $this->apprenant = $apprenant;

        return $this;
    }

    public function getArchivage(): ?bool
    {
        return $this->archivage;
    }

    public function setArchivage(?bool $archivage): self
    {
        $this->archivage = $archivage;

        return $this;
    }

    /**
     * @return Collection|Commentaires[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaires $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setLivrableRendu($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getLivrableRendu() === $this) {
                $commentaire->setLivrableRendu(null);
            }
        }

        return $this;
    }
}
