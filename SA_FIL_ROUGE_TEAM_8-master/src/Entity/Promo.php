<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     denormalizationContext={"groups"={"postPromo"}},
 *     normalizationContext={"groups"={"showPromo"}},
 *     collectionOperations={
 *      "post_Promo"={
 *          "method"="POST",
 *        "path"="admin/promo" ,
 *        "route_name"="add_Promo"
 *     },
 *     "get"={
 *      "path"="admin/promo",
 *     },
 *         "get_Groupe_Principals_promo_apprenants"={
 *          "method"="GET",
 *        "path"="admin/promos/principal" ,
 *        "route_name"="get_Groupe_Principal_promos"
 *     },
 *         "get_liste_attente"={
 *          "method"="GET",
 *        "path"="admin/promo/apprenants/attente" ,
 *        "route_name"="get_liste_attente_promo"
 *     },
 *       "getAllPromoEnCours"={
 *          "method"="GET",
 *        "path"="api/admin/promo/encours" ,
 *        "route_name"="get_All_promo_encours"
 *     },
 *       "getApprenantByProfilDeSortiePromo"={
 *          "method"="GET",
 *        "path"="api/admin/promo/{idPro}/profilDeSortie/{id}/apprenants" ,
 *        "route_name"="get_ApprenantByProfilDeSortiePromo",
 *        "security"="is_granted('ROLE_CM')",
 *        "security_message"="Vous n'avez pas access à cette Ressource",
 *     }
 *     },
 *     itemOperations={
 *   "get"={
 *      "path"="/admin/promo/{id}"
 *     },
 *         "get_enCoursOne"={
 *          "method"="GET",
 *        "path"="api/admin/promo/{id}/encours" ,
 *        "route_name"="get_one_promo_encours"
 *     },
 *     "get_One_Principal"={
 *          "method"="GET",
 *        "path"="api/admin/promo/{id}/principal" ,
 *        "route_name"="get_one_promo_principal"
 *     },
 *     "get_Promo_Referentiel"={
 *          "method"="GET",
 *        "path"="api/admin/promo/{id}/referentiels" ,
 *        "route_name"="get_one_promo_referentiels"
 *     }
 *     ,
 *     "get_Attente_Referentiel"={
 *          "method"="GET",
 *        "path"="api/admin/promo/{id}/apprenants/attente" ,
 *        "route_name"="get_Attente_promo_referentiels"
 *     },
 *      "put_statut_groupe"={
 *          "method"="put",
 *        "path"="api/admin/promo/{id}/groupes/{idG}" ,
 *        "route_name"="modifierStatutGroupe"
 *     },
 *      "putAddDeleteApprenant"={
 *          "method"="put",
 *        "path"="api/admin/promo/{id}/apprenants" ,
 *        "route_name"="addDeleteApprenant"
 *     }
 *     ,
 *      "putAddDeleteFormateur"={
 *          "method"="put",
 *        "path"="api/admin/promo/{id}/formateurs" ,
 *        "route_name"="addDeleteFormateur"
 *     }  ,
 *      "putPromoReferent"={
 *          "method"="put",
 *        "path"="api/admin/promo/{id}" ,
 *        "route_name"="updatePromoRef"
 *     },
 *     "getFormateurs"={
 *          "method"="GET",
 *        "path"="api/admin/promo/{id}/formateurs" ,
 *        "normalization_context"={"groups":"promo:read"},
 *        "route_name"="listerFormateursGet",
 *     },
 *      "getApprntByGrpPromo"={
 *          "method"="GET",
 *        "path"="api/admin/promos/{idPro}/groupes/{id}/apprenants" ,
 *      "read"=false,
 *        "route_name"="getApprenantByGrpes",
 *        "normalization_context"={"groups":"groupeAprpenant:read"},
 *     },
 *      "putProfilSortieAll"={
 *          "method"="PUT",
 *        "path"="api/admin/promo/{id}/apprenants/profilDeSortie" ,
 *        "route_name"="updateProfilSortieAll",
 *     }
 *     }
 * )
 * @ORM\Entity(repositoryClass=PromoRepository::class)
 */
class Promo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"showPromo","postGroupe","showUtil","groupeAprpenant:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"showPromo","promo:read","groupeAprpenant:read"})
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"showPromo","groupeAprpenant:read"})
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"showPromo","groupeAprpenant:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"showPromo","groupeAprpenant:read"})
     */
    private $lieu;



    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"showPromo","groupeAprpenant:read"})
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"showPromo","groupeAprpenant:read"})
     */
    private $dateFinProvisoire;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"showPromo","groupeAprpenant:read"})
     */
    private $fabrique;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"showPromo","groupeAprpenant:read"})
     */
    private $dateFinReelle;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"showPromo","groupeAprpenant:read"})
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=Referentiel::class, inversedBy="promo", cascade={"persist"})
     * @Groups({"showPromo","groupeAprpenant:read"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $referentiel;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="promo", cascade={"persist"})
     * @Groups({"showPromo","groupeAprpenant:read"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $groupe;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="promos", cascade={"persist"})
     * @Groups({"showPromo"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $formateur;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="promos", cascade={"persist"})
     * @Groups({"showPromo"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=FilDeDiscussion::class, mappedBy="promo")
     */
    private $filDeDiscussions;

    /**
     * @ORM\OneToMany(targetEntity=PromoBrief::class, mappedBy="promo")
     */
    private $promoBriefs;

    /**
     * @ORM\OneToMany(targetEntity=StatistiquesCompetences::class, mappedBy="promo")
     */
    private $statistiquesCompetences;

    public function __construct()
    {
        $this->groupe = new ArrayCollection();
        $this->formateur = new ArrayCollection();
        $this->filDeDiscussions = new ArrayCollection();
        $this->promoBriefs = new ArrayCollection();
        $this->statistiquesCompetences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(?string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }




    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(?\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFinProvisoire(): ?\DateTimeInterface
    {
        return $this->dateFinProvisoire;
    }

    public function setDateFinProvisoire(?\DateTimeInterface $dateFinProvisoire): self
    {
        $this->dateFinProvisoire = $dateFinProvisoire;

        return $this;
    }

    public function getFabrique(): ?string
    {
        return $this->fabrique;
    }

    public function setFabrique(?string $fabrique): self
    {
        $this->fabrique = $fabrique;

        return $this;
    }

    public function getDateFinReelle(): ?\DateTimeInterface
    {
        return $this->dateFinReelle;
    }

    public function setDateFinReelle(?\DateTimeInterface $dateFinReelle): self
    {
        $this->dateFinReelle = $dateFinReelle;

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): self
    {
        $this->etat = $etat;

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

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupe(): Collection
    {
        return $this->groupe;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupe->contains($groupe)) {
            $this->groupe[] = $groupe;
            $groupe->setPromo($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupe->contains($groupe)) {
            $this->groupe->removeElement($groupe);
            // set the owning side to null (unless already changed)
            if ($groupe->getPromo() === $this) {
                $groupe->setPromo(null);
            }
        }

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|FilDeDiscussion[]
     */
    public function getFilDeDiscussions(): Collection
    {
        return $this->filDeDiscussions;
    }

    public function addFilDeDiscussion(FilDeDiscussion $filDeDiscussion): self
    {
        if (!$this->filDeDiscussions->contains($filDeDiscussion)) {
            $this->filDeDiscussions[] = $filDeDiscussion;
            $filDeDiscussion->setPromo($this);
        }

        return $this;
    }

    public function removeFilDeDiscussion(FilDeDiscussion $filDeDiscussion): self
    {
        if ($this->filDeDiscussions->contains($filDeDiscussion)) {
            $this->filDeDiscussions->removeElement($filDeDiscussion);
            // set the owning side to null (unless already changed)
            if ($filDeDiscussion->getPromo() === $this) {
                $filDeDiscussion->setPromo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PromoBrief[]
     */
    public function getPromoBriefs(): Collection
    {
        return $this->promoBriefs;
    }

    public function addPromoBrief(PromoBrief $promoBrief): self
    {
        if (!$this->promoBriefs->contains($promoBrief)) {
            $this->promoBriefs[] = $promoBrief;
            $promoBrief->setPromo($this);
        }

        return $this;
    }

    public function removePromoBrief(PromoBrief $promoBrief): self
    {
        if ($this->promoBriefs->contains($promoBrief)) {
            $this->promoBriefs->removeElement($promoBrief);
            // set the owning side to null (unless already changed)
            if ($promoBrief->getPromo() === $this) {
                $promoBrief->setPromo(null);
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
            $statistiquesCompetence->setPromo($this);
        }

        return $this;
    }

    public function removeStatistiquesCompetence(StatistiquesCompetences $statistiquesCompetence): self
    {
        if ($this->statistiquesCompetences->contains($statistiquesCompetence)) {
            $this->statistiquesCompetences->removeElement($statistiquesCompetence);
            // set the owning side to null (unless already changed)
            if ($statistiquesCompetence->getPromo() === $this) {
                $statistiquesCompetence->setPromo(null);
            }
        }

        return $this;
    }
}
