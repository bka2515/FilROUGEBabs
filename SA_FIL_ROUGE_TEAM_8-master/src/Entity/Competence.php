<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     denormalizationContext={"groups"={"poster"}},
 *     normalizationContext={"groups"={"ttt"}},
 *     collectionOperations={
 *      "get_Competence_liste"={
 *        "method"="GET",
 *        "path"="/admin/competences" ,
 *        "route_name"="Competence_liste"
 *     }
 *      ,
 *       "postCompetence"={
 *        "method"="POST",
 *        "path"="/admin/competences" ,
 *        "route_name"="competence_add"
 *     }
 *     },
 *   itemOperations={
 *      "get_One_Competence"={
 *        "method"="POST",
 *        "path"="/admin/competences/{id}" ,
 *        "route_name"="Competence_One"
 *     },
 *     "put_One_Competence"={
 *        "method"="PUT",
 *        "path"="/admin/competences/{id}" ,
 *        "route_name"="put_Competence"
 *     },
 *     "get"
 *     }
 * )
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 */
class Competence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *@Groups({"post","okk","ttt","poster"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"post","okk","ttt","poster"})
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetences::class, mappedBy="competence")
     *  @Groups({"post","poster"})
     */
    private $groupeCompetences;

    /**
     * @ORM\ManyToMany(targetEntity=Niveau::class, mappedBy="competence", cascade={"persist"})
     * @Groups({"ttt"})
     */
    private $niveaux;

    /**
     * @ORM\OneToMany(targetEntity=StatistiquesCompetences::class, mappedBy="competence")
     */
    private $statistiquesCompetences;

    public function __construct()
    {
        $this->groupeCompetences = new ArrayCollection();
        $this->niveaux = new ArrayCollection();
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
            $groupeCompetence->addCompetence($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        if ($this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences->removeElement($groupeCompetence);
            $groupeCompetence->removeCompetence($this);
        }

        return $this;
    }

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveaux(): Collection
    {
        return $this->niveaux;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveaux->contains($niveau)) {
            $this->niveaux[] = $niveau;
            $niveau->addCompetence($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveaux->contains($niveau)) {
            $this->niveaux->removeElement($niveau);
            $niveau->removeCompetence($this);
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
            $statistiquesCompetence->setCompetence($this);
        }

        return $this;
    }

    public function removeStatistiquesCompetence(StatistiquesCompetences $statistiquesCompetence): self
    {
        if ($this->statistiquesCompetences->contains($statistiquesCompetence)) {
            $this->statistiquesCompetences->removeElement($statistiquesCompetence);
            // set the owning side to null (unless already changed)
            if ($statistiquesCompetence->getCompetence() === $this) {
                $statistiquesCompetence->setCompetence(null);
            }
        }

        return $this;
    }
}
