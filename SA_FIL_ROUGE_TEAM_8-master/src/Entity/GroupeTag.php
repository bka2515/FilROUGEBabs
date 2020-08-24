<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeTagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *      attributes={"force_eager"=false,"denormalization_context"={"groups"={"writeCOGrpTag"},"enable_max_depth"=true}},
 *      denormalizationContext={"groups"={"tagAdd"}},
 *     normalizationContext={"groups"={"grpTagRead"}},
 *       collectionOperations={
 *        "get"={
 *         "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') ",
 *        "security_message"="Vous n'avez pas access à cette Ressource",
 *      "path"="/admin/grptags",
 *
 *     },
 *        "post_GroupeTagsTag"={
 *      "method"="POST",
 *     "path"="/admin/grptags",
 *     "route_name"="post_GroupeTagsTag"
 *     }
 *     },
 *      itemOperations={
 *        "get"={
 *     "path"="/admin/grptags/{id}"
 * },
 *
 *     "update_GroupeTagsTag"={
 *        "method"="PUT",
 *        "path"="/admin/grptags/{id}" ,
 *        "route_name"="modifier_GroupeTagsTag",

 *     },
 *           "get_tags_by_liste_tags"={
 *        "method"="GET",
 *        "path"="api/admin/grptags/{id}/tags" ,
 *        "route_name"="groupeTag_liste_Tag",
 *     },
 *     },
 * )
 * @ORM\Entity(repositoryClass=GroupeTagRepository::class)
 */
class GroupeTag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"getTag","grpTagRead","showTag"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"tagAdd","getTag","grpTagRead","showTag"})
     */
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="groupeTags", cascade={"persist"})
     * @Groups({"tagAdd","getTag","grpTagRead"})
     */
    private $tag;

    public function __construct()
    {
        $this->tag = new ArrayCollection();
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
     * @return Collection|Tag[]
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tag->contains($tag)) {
            $this->tag[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tag->contains($tag)) {
            $this->tag->removeElement($tag);
        }

        return $this;
    }
}
