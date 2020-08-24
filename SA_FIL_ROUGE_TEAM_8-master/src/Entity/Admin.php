<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AdminRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=AdminRepository::class)
 */
class Admin extends User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\OneToMany(targetEntity=GroupeCompetences::class, mappedBy="admin")
     *  @Groups({"get"})
     */
    private $groupeCompetence;

    public function __construct()
    {
        $this->groupeCompetence = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return Collection|GroupeCompetences[]
     */
    public function getGroupeCompetence(): Collection
    {
        return $this->groupeCompetence;
    }

    public function addGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        if (!$this->groupeCompetence->contains($groupeCompetence)) {
            $this->groupeCompetence[] = $groupeCompetence;
            $groupeCompetence->setAdmin($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        if ($this->groupeCompetence->contains($groupeCompetence)) {
            $this->groupeCompetence->removeElement($groupeCompetence);
            // set the owning side to null (unless already changed)
            if ($groupeCompetence->getAdmin() === $this) {
                $groupeCompetence->setAdmin(null);
            }
        }

        return $this;
    }
}
