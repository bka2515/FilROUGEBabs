<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ReferentielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"getGroupeCompte"}},
 *     collectionOperations={
 *      "get"={"security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_CM') or is_granted('ROLE_FORMATEUR')",
 *     "path"="/admin/referentiels",
 * },
 *      "add_referentiel"={
 *          "method"="POST",
 *        "path"="/api/admin/referentiels" ,
 *        "route_name"="postReferentiel"
 *     },
 *      "get_all_groupecompetencesBy_Referentiel"={
 *        "method"="GET",
 *        "path"="/admin/referentiels/groupecompetences" ,
 *        "access_control"="(is_granted('ROLE_ADMIN') )",
 *        "access_control_message"="Vous n'avez pas access à cette Ressource",
 *        "route_name"="groupecompetences_by_referentiel"
 *     }
 *     },
 *     itemOperations={
 *      "get"={
 *      "path"="/admin/referentiels/{id}",
 *     },
 *      "get_competence_by_grpeCptence"={
 *        "method"="GET",
 *        "path"="/admin/referentiels/{idRef}/grpecompetences" ,
 *        "route_name"="competence_by_grpeCptence",
 *     },
 *      "putReferModif"={
 *        "method"="PUT",
 *        "path"="api/admin/referentiels/{id}" ,
 *        "route_name"="updatingRefer",
 *     }
 *     }
 * )
 * @ORM\Entity(repositoryClass=ReferentielRepository::class)
 */
class Referentiel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"getGroupeCompte","showPromo"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"getGroupeCompte","showPromo"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"getGroupeCompte","showPromo"})
     */
    private $presentation;

    /**
     * @ORM\Column(type="blob",nullable=true)
     * @Groups({"getGroupeCompte","showPromo"})
     */
    private $programme;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"getGroupeCompte","showPromo"})
     */
    private $critereAdmission;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"getGroupeCompte","showPromo"})
     */
    private $critereEvaluation;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetences::class, mappedBy="referentiel")
     * @Groups({"getGroupeCompte"})
     */
    private $groupeCompetences;

    /**
     * @ORM\OneToMany(targetEntity=Promo::class, mappedBy="referentiel")
     */
    private $promo;

    /**
     * @ORM\OneToMany(targetEntity=Brief::class, mappedBy="referentiel")
     */
    private $briefs;

    /**
     * @ORM\OneToMany(targetEntity=StatistiquesCompetences::class, mappedBy="referentiel")
     */
    private $statistiquesCompetences;

    public function __construct()
    {
        $this->groupeCompetences = new ArrayCollection();
        $this->promo = new ArrayCollection();
        $this->briefs = new ArrayCollection();
        $this->statistiquesCompetences = new ArrayCollection();
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

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getProgramme()
    {
        return (string) $this->programme;
    }

    public function setProgramme( $programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    public function getCritereAdmission(): ?string
    {
        return $this->critereAdmission;
    }

    public function setCritereAdmission(?string $critereAdmission): self
    {
        $this->critereAdmission = $critereAdmission;

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
     * @return Collection|GroupeCompetences[]
     */
    public function getGroupeCompetences(): Collection
    {
        return $this->groupeCompetences;
    }

    public function addGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        if (!$this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences[] = $groupeCompetence;
            $groupeCompetence->addReferentiel($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        if ($this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences->removeElement($groupeCompetence);
            $groupeCompetence->removeReferentiel($this);
        }

        return $this;
    }

    /**
     * @return Collection|Promo[]
     */
    public function getPromo(): Collection
    {
        return $this->promo;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promo->contains($promo)) {
            $this->promo[] = $promo;
            $promo->setReferentiel($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promo->contains($promo)) {
            $this->promo->removeElement($promo);
            // set the owning side to null (unless already changed)
            if ($promo->getReferentiel() === $this) {
                $promo->setReferentiel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Brief[]
     */
    public function getBriefs(): Collection
    {
        return $this->briefs;
    }

    public function addBrief(Brief $brief): self
    {
        if (!$this->briefs->contains($brief)) {
            $this->briefs[] = $brief;
            $brief->setReferentiel($this);
        }

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        if ($this->briefs->contains($brief)) {
            $this->briefs->removeElement($brief);
            // set the owning side to null (unless already changed)
            if ($brief->getReferentiel() === $this) {
                $brief->setReferentiel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|StatistiquesCompetences[]
     */
    public function getStatistiquesCompetences(): Collection
    {
        return $this->statistiquesCompetences;
    }

    public function addStatistiquesCompetence(StatistiquesCompetences $statistiquesCompetence): self
    {
        if (!$this->statistiquesCompetences->contains($statistiquesCompetence)) {
            $this->statistiquesCompetences[] = $statistiquesCompetence;
            $statistiquesCompetence->setReferentiel($this);
        }

        return $this;
    }

    public function removeStatistiquesCompetence(StatistiquesCompetences $statistiquesCompetence): self
    {
        if ($this->statistiquesCompetences->contains($statistiquesCompetence)) {
            $this->statistiquesCompetences->removeElement($statistiquesCompetence);
            // set the owning side to null (unless already changed)
            if ($statistiquesCompetence->getReferentiel() === $this) {
                $statistiquesCompetence->setReferentiel(null);
            }
        }

        return $this;
    }
}
