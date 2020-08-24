<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentaireGeneralRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CommentaireGeneralRepository::class)
 */
class CommentaireGeneral
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"read:comment"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"read:comment"})
     */
    private $date;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Groups({"read:comment"})
     */
    private $pieceJointe;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $archivage;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commentaireGenerals")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=FilDeDiscussion::class, inversedBy="commentaireGenerals")
     */
    private $FilDeDiscussion;

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

    public function getArchivage(): ?bool
    {
        return $this->archivage;
    }

    public function setArchivage(?bool $archivage): self
    {
        $this->archivage = $archivage;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFilDeDiscussion(): ?FilDeDiscussion
    {
        return $this->FilDeDiscussion;
    }

    public function setFilDeDiscussion(?FilDeDiscussion $FilDeDiscussion): self
    {
        $this->FilDeDiscussion = $FilDeDiscussion;

        return $this;
    }
}
