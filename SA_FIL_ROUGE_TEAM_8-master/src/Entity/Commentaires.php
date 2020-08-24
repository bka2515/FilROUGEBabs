<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentairesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CommentairesRepository::class)
 */
class Commentaires
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
    private $libelle;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $pieceJointe;

    /**
     * @ORM\ManyToOne(targetEntity=LivrableRendu::class, inversedBy="commentaires")
     */
    private $LivrableRendu;

    /**
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="commentaires")
     */
    private $formateur;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $archivage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPieceJointe()
    {
        return $this->pieceJointe;
    }

    public function setPieceJointe($pieceJointe): self
    {
        $this->pieceJointe = $pieceJointe;

        return $this;
    }

    public function getLivrableRendu(): ?LivrableRendu
    {
        return $this->LivrableRendu;
    }

    public function setLivrableRendu(?LivrableRendu $LivrableRendu): self
    {
        $this->LivrableRendu = $LivrableRendu;

        return $this;
    }

    public function getFormateur(): ?Formateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Formateur $formateur): self
    {
        $this->formateur = $formateur;

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
}
