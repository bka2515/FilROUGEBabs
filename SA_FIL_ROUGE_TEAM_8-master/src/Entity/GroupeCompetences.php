<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\GroupeCompetencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ApiResource(
 *     attributes={"force_eager"=false,"denormalization_context"={"groups"={"writeCO"},"enable_max_depth"=true}},
 *denormalizationContext={"groups"={"post"}},
 *normalizationContext={"groups"={"okk"}},
 *     collectionOperations={
 *     "get_groupeCompetence_liste"={
 *        "method"="GET",
 *        "path"="/admin/grpecompetences" ,
 *        "route_name"="groupeCompetence_liste",
 *     },
 *       "get_groupeCompetence_liste_cptences"={
 *        "method"="GET",
 *        "path"="/admin/grpecompetences/competences" ,
 *        "route_name"="groupeCompetence_liste_competces",
 *     },
 *     "post_grpe_cptence"={
 *     "method"="POST",
 *     "security_post_denormalize"="is_granted('POST_GROUPE',object)",
 *     "path"="/admin/grpecompetences",
 *     "route_name"="post_groupeCompetenceCpt",
 *     },
 *
 *     },
 *     itemOperations={
 *           "getOneGroupeCompetence"={
 *        "method"="GET",
 *        "path"="admin/grpecompetences/{id}" ,
 *        "route_name"="get_groupeCompetenceOne",
 *     },
 *          "getCompetenceByGroupeCompetence"={
 *        "method"="GET",
 *        "path"="/admin/grpecompetences/{id}/competences" ,
 *        "route_name"="get_CompetenceByGrp",
 *     },
 *
 *     "put_grpe_cptence"={
 *     "method"="PUT",
 *          "path"="/admin/grpecompetences/{id}",
 *          "route_name"="put_groupeCompetenceCpt",
 *     }
 *     }
 * )
 * @ORM\Entity(repositoryClass=GroupeCompetencesRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class GroupeCompetences
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"okk","poster","getGroupeCompte"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *@Groups({"post","okk","poster","getGroupeCompte"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotNull()
     *  @Groups({"post","okk","poster","getGroupeCompte"})
     */
    private $descriptif;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, inversedBy="groupeCompetences", cascade={"persist"})
     * @Assert\NotBlank()
     * @Groups({"post","okk","poster"})
     */

    private $competence;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, inversedBy="groupeCompetences")
     *  @Groups({"post"})
     *
     */
    private $referentiel;

    /**
     * @ORM\ManyToOne(targetEntity=Admin::class, inversedBy="groupeCompetence")
     *  @Groups({"post"})
     */
    private $admin;

    public function __construct()
    {
        $this->competence = new ArrayCollection();
        $this->referentiel = new ArrayCollection();
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

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(?string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    /**
     * @return Collection|Competence[]
     * @Groups({"post"})
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

    /**
     * @return Collection|Referentiel[]
     */
    public function getReferentiel(): Collection
    {
        return $this->referentiel;
    }

    public function addReferentiel(Referentiel $referentiel): self
    {
        if (!$this->referentiel->contains($referentiel)) {
            $this->referentiel[] = $referentiel;
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiel->contains($referentiel)) {
            $this->referentiel->removeElement($referentiel);
        }

        return $this;
    }


    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(?Admin $admin): self
    {
        $this->admin = $admin;

        return $this;
    }
}
