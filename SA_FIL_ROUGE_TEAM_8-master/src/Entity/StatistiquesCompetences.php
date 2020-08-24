<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StatistiquesCompetencesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=StatistiquesCompetencesRepository::class)
 */
class StatistiquesCompetences
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Niveau1;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Niveau2;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $Niveau3;

    /**
     * @ORM\ManyToOne(targetEntity=Referentiel::class, inversedBy="statistiquesCompetences")
     */
    private $referentiel;

    /**
     * @ORM\ManyToOne(targetEntity=Competence::class, inversedBy="statistiquesCompetences")
     */
    private $competence;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="statistiquesCompetences")
     */
    private $promo;

    /**
     * @ORM\ManyToOne(targetEntity=Apprenant::class, inversedBy="statistiquesCompetences")
     */
    private $apprenant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNiveau1(): ?bool
    {
        return $this->Niveau1;
    }

    public function setNiveau1(?bool $Niveau1): self
    {
        $this->Niveau1 = $Niveau1;

        return $this;
    }

    public function getNiveau2(): ?bool
    {
        return $this->Niveau2;
    }

    public function setNiveau2(?bool $Niveau2): self
    {
        $this->Niveau2 = $Niveau2;

        return $this;
    }

    public function getNiveau3(): ?bool
    {
        return $this->Niveau3;
    }

    public function setNiveau3(?bool $Niveau3): self
    {
        $this->Niveau3 = $Niveau3;

        return $this;
    }

    public function getReferentiel(): ?Referentiel
    {
        return $this->referentiel;
    }

    public function setReferentiel(?Referentiel $referentiel): self
    {
        $this->referentiel = $referentiel;

        return $this;
    }

    public function getCompetence(): ?Competence
    {
        return $this->competence;
    }

    public function setCompetence(?Competence $competence): self
    {
        $this->competence = $competence;

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

    public function getApprenant(): ?Apprenant
    {
        return $this->apprenant;
    }

    public function setApprenant(?Apprenant $apprenant): self
    {
        $this->apprenant = $apprenant;

        return $this;
    }
}
