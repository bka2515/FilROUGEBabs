<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\NiveauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"niveau:show"}},
 * )
 * @ORM\Entity(repositoryClass=NiveauRepository::class)
 */
class Niveau
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"ttt","niveau:show"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"ttt","niveau:show"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"ttt","niveau:show"})
     */
    private $groupeActionARealiser;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"ttt","niveau:show"})
     */
    private $critereEvaluation;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, inversedBy="niveaux", cascade={"persist"})
     */
    private $competence;

    /**
     * @ORM\ManyToOne(targetEntity=Brief::class, inversedBy="niveau")
     */
    private $brief;

    /**
     * @ORM\ManyToMany(targetEntity=LivrablesPartiels::class, mappedBy="Niveau")
     */
    private $livrablesPartiels;

    public function __construct()
    {
        $this->competence = new ArrayCollection();
        $this->livrablesPartiels = new ArrayCollection();
    }

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

    public function getGroupeActionARealiser(): ?string
    {
        return $this->groupeActionARealiser;
    }

    public function setGroupeActionARealiser(?string $groupeActionARealiser): self
    {
        $this->groupeActionARealiser = $groupeActionARealiser;

        return $this;
    }

    public function getCritereEvaluation(): ?string
    {
        return $this->critereEvaluation;
    }

    public function setCritereEvaluation(?string $critereEvaluation): self
    {
        $this->critereEvaluation = $critereEvaluation;

        return $this;
    }

    /**
     * @return Collection|Competence[]
     */
    public function getCompetence(): Collection
    {
        return $this->competence;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competence->contains($competence)) {
            $this->competence[] = $competence;
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        if ($this->competence->contains($competence)) {
            $this->competence->removeElement($competence);
        }

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
    public function getLivrablesPartiels(): Collection
    {
        return $this->livrablesPartiels;
    }

    public function addLivrablesPartiel(LivrablesPartiels $livrablesPartiel): self
    {
        if (!$this->livrablesPartiels->contains($livrablesPartiel)) {
            $this->livrablesPartiels[] = $livrablesPartiel;
            $livrablesPartiel->addNiveau($this);
        }

        return $this;
    }

    public function removeLivrablesPartiel(LivrablesPartiels $livrablesPartiel): self
    {
        if ($this->livrablesPartiels->contains($livrablesPartiel)) {
            $this->livrablesPartiels->removeElement($livrablesPartiel);
            $livrablesPartiel->removeNiveau($this);
        }

        return $this;
    }
}
