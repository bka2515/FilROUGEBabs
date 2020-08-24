<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *normalizationContext={"groups"={"showTag"}},
 *         denormalizationContext={"groups"={"postTag"}},
 *     collectionOperations={
 *        "get"={
 *          "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') ",
 *        "security_message"="Vous n'avez pas access à cette Ressource",
 *     "path"="/admin/tags",
 *     },
 *        "postTag"={
*        "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') ",
 *        "security_message"="Vous n'avez pas access à cette Ressource",
 *      "path"="/admin/tags",
 *            "route_name"="post_Tag",
 *     }
 *     },
 *      itemOperations={
 *        "get"={
 *"security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') ",
 *        "security_message"="Vous n'avez pas access à cette Ressource", *     "path"="/admin/tags/{id}",
 *     },
 *       "putTag"={
 *         "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') ",
 *        "security_message"="Vous n'avez pas access à cette Ressource",
 *      "path"="/admin/tags/{id}",
 *            "route_name"="put_Tag",
 *     }
 *     },
 *
 * )
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"grpeTag:read","getTag","postTag","showTag","grpTagRead"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"tagAdd","getTag","postTag","showTag","grpTagRead"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"tagAdd","getTag","postTag","showTag","grpTagRead","grpeTag:read","tagadd"})
     */
    private $descriptif;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeTag::class, mappedBy="tag")
     * @Groups({"postTag","grpTagRead"})
     */
    private $groupeTags;

    /**
     * @ORM\ManyToMany(targetEntity=Brief::class, mappedBy="tag")
     */
    private $briefs;

    public function __construct()
    {
        $this->groupeTags = new ArrayCollection();
        $this->briefs = new ArrayCollection();
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
     * @return Collection|GroupeTag[]
     */
    public function getGroupeTags(): Collection
    {
        return $this->groupeTags;
    }

    public function addGroupeTag(GroupeTag $groupeTag): self
    {
        if (!$this->groupeTags->contains($groupeTag)) {
            $this->groupeTags[] = $groupeTag;
            $groupeTag->addTag($this);
        }

        return $this;
    }

    public function removeGroupeTag(GroupeTag $groupeTag): self
    {
        if ($this->groupeTags->contains($groupeTag)) {
            $this->groupeTags->removeElement($groupeTag);
            $groupeTag->removeTag($this);
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
            $brief->addTag($this);
        }

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        if ($this->briefs->contains($brief)) {
            $this->briefs->removeElement($brief);
            $brief->removeTag($this);
        }

        return $this;
    }
}
