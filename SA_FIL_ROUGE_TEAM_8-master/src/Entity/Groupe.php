<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *          attributes={"force_eager"=false,"denormalization_context"={"groups"={"writeGRP"},"enable_max_depth"=true}},
 *     normalizationContext={"groups"={"getGroupe"}},
 *      denormalizationContext={"groups"={"postGroupe"}},
 *            collectionOperations={
 *        "AllGroupes"={
 *          "path"="api/admin/groupes",
 *      "route_name"="getAllGroupes",
 *     "method"="GET",
 *     },
 *        "post_group_creer"={
 *    "method"="POST",
 *        "path"="/admin/groupes" ,
 *        "route_name"="add_groupe_creer",
 *     },
 *    "groupe_pprenants_liste_show"={
 *        "method"="GET",
 *        "path"="api/admin/groupe/apprenants" ,
 *          "normalization_context"={"groups":"groupePromo"},
 *        "route_name"="groupe_apprenants_show",
 *     },
 *
 *
 *     },
 *      itemOperations={
 *     "get"={
*       "path"="/admin/groupes/{id}",
 *        "normalization_context"={"groups":"groupePromo"},
 *     },
 *     "put_groupe"={
 *      "path"="/admin/groupes/{id}",
 *       "method"="PUT",
 *
 *      "route_name"="modifierGroupe",
 *     },
 *      "groupe_remove_apprenants"={
 *        "method"="DELETE",
 *        "path"="admin/groupes/{id}/apprenants/{idApprenant}" ,
 *        "route_name"="remove_apprenant_groupe",
 *     },
 *
 *     }
 * )
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 */
class Groupe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"getGroupe","postGroupe","groupePromo","showPromo"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Groups({"getGroupe","postGroupe","showPromo","groupePromo"})
     */
    private $nom;

    /**
     * @ORM\Column(type="date", nullable=true)
     *  @Groups({"getGroupe","postGroupe","showPromo","groupePromo"})
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     *  @Groups({"getGroupe","postGroupe","showPromo","groupePromo"})
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Groups({"getGroupe","postGroupe","showPromo","groupePromo"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="groupe", cascade={"persist"})
     *  @Groups({"getGroupe","postGroupe","groupePromo"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $promo;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="groupes", cascade={"persist"})
     *  @Groups({"getGroupe","postGroupe","groupePromo"})
     */
    private $formateur;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, inversedBy="groupes", cascade={"persist"})
     *  @Groups({"getGroupe","postGroupe","showPromo","groupePromo"})
     */
    private $apprenant;

    /**
     * @ORM\ManyToMany(targetEntity=Brief::class, mappedBy="groupe")
     */
    private $briefs;

    public function __construct()
    {
        $this->formateur = new ArrayCollection();
        $this->apprenant = new ArrayCollection();
        $this->briefs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(?bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

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

    /**
     * @return Collection|Formateur[]
     */
    public function getFormateur(): Collection
    {
        return $this->formateur;
    }

    public function addFormateur(Formateur $formateur): self
    {
        if (!$this->formateur->contains($formateur)) {
            $this->formateur[] = $formateur;
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        if ($this->formateur->contains($formateur)) {
            $this->formateur->removeElement($formateur);
        }

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenant(): Collection
    {
        return $this->apprenant;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenant->contains($apprenant)) {
            $this->apprenant[] = $apprenant;
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenant->contains($apprenant)) {
            $this->apprenant->removeElement($apprenant);
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
            $brief->addGroupe($this);
        }

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        if ($this->briefs->contains($brief)) {
            $this->briefs->removeElement($brief);
            $brief->removeGroupe($this);
        }

        return $this;
    }
}
