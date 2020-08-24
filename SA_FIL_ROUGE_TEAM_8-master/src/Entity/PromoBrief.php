<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PromoBriefRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=PromoBriefRepository::class)
 */
class PromoBrief
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
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="promoBriefs")
     */
    private $promo;

    /**
     * @ORM\ManyToOne(targetEntity=Brief::class, inversedBy="promoBriefs")
     */
    private $brief;

    /**
     * @ORM\OneToMany(targetEntity=LivrablesPartiels::class, mappedBy="promoBrief")
     */
    private $livrablePartiels;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $archivage;

    /**
     * @ORM\OneToMany(targetEntity=PromoBriefApprenant::class, mappedBy="promobrief")
     */
    private $promoBriefApprenants;

    public function __construct()
    {
        $this->livrablePartiels = new ArrayCollection();
        $this->promoBriefApprenants = new ArrayCollection();
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

    public function getPromo(): ?Promo
    {
        return $this->promo;
    }

    public function setPromo(?Promo $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    public function getBrief(): ?Brief
    {
        return $this->brief;
    }

    public function setBrief(?Brief $brief): self
    {
        $this->brief = $brief;

        return $this;
    }

    /**
     * @return Collection|LivrablesPartiels[]
     */
    public function getLivrablePartiels(): Collection
    {
        return $this->livrablePartiels;
    }

    public function addLivrablePartiel(LivrablesPartiels $livrablePartiel): self
    {
        if (!$this->livrablePartiels->contains($livrablePartiel)) {
            $this->livrablePartiels[] = $livrablePartiel;
            $livrablePartiel->setPromoBrief($this);
        }

        return $this;
    }

    public function removeLivrablePartiel(LivrablesPartiels $livrablePartiel): self
    {
        if ($this->livrablePartiels->contains($livrablePartiel)) {
            $this->livrablePartiels->removeElement($livrablePartiel);
            // set the owning side to null (unless already changed)
            if ($livrablePartiel->getPromoBrief() === $this) {
                $livrablePartiel->setPromoBrief(null);
            }
        }

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
     * @return Collection|PromoBriefApprenant[]
     */
    public function getPromoBriefApprenants(): Collection
    {
        return $this->promoBriefApprenants;
    }

    public function addPromoBriefApprenant(PromoBriefApprenant $promoBriefApprenant): self
    {
        if (!$this->promoBriefApprenants->contains($promoBriefApprenant)) {
            $this->promoBriefApprenants[] = $promoBriefApprenant;
            $promoBriefApprenant->setPromobrief($this);
        }

        return $this;
    }

    public function removePromoBriefApprenant(PromoBriefApprenant $promoBriefApprenant): self
    {
        if ($this->promoBriefApprenants->contains($promoBriefApprenant)) {
            $this->promoBriefApprenants->removeElement($promoBriefApprenant);
            // set the owning side to null (unless already changed)
            if ($promoBriefApprenant->getPromobrief() === $this) {
                $promoBriefApprenant->setPromobrief(null);
            }
        }

        return $this;
    }
}
