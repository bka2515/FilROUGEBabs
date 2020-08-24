<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\ProfilSortieController;
use App\Repository\ProfilSortieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     collectionOperations={
 * "get"={
 *      "path"="/admin/profilsortie",
 *              "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_CM')",
 *        "security_message"="Vous n'avez pas access à cette Ressource",
 *     },
 *     "post"={
*    "path"="/admin/profilsortie",
 *            "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_CM')",
 *        "security_message"="Vous n'avez pas access à cette Ressource",
 *     }
 *     },
 *     itemOperations={
 * "put",
 *   "get"={
 *      "path"="/admin/profilsortie/{id}",
 *        "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_CM')",
 *        "security_message"="Vous n'avez pas access à cette Ressource",
 *     },
 *     
 *     
 *     }
 * )
 * @ORM\Entity(repositoryClass=ProfilSortieRepository::class)
 */
class ProfilSortie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="profilSortie")
     */
    private $apprenant;

    public function __construct()
    {
        $this->apprenant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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
            $apprenant->setProfilSortie($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenant->contains($apprenant)) {
            $this->apprenant->removeElement($apprenant);
            // set the owning side to null (unless already changed)
            if ($apprenant->getProfilSortie() === $this) {
                $apprenant->setProfilSortie(null);
            }
        }

        return $this;
    }
}
