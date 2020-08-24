<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType("JOINED")
 *  @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"user" = "User", "apprenant" = "Apprenant", "formateur" = "Formateur","cm" = "CM","admin" = "Admin"})
 * @ApiResource(
 *   collectionOperations={
 *   " getAllUsers"={
 *        "method"="GET",
 *        "path"="/admin/users" ,
 *        "access_control"="(is_granted('ROLE_ADMIN') )",
 *        "access_control_message"="Vous n'avez pas access à cette Ressource",
 *        "route_name"="getUtilisateurs"
 *     },
 *     "post"={"security"="is_granted('ROLE_ADMIN')"},
 *     "get_apprenants"={
 *        "method"="GET",
 *        "path"="/apprenants" ,
 *        "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM')",
 *        "security_message"="Vous n'avez pas access à cette Ressource",
 *        "route_name"="apprenant_liste"
 *     },
 *      "get_apprenants"={
 *        "method"="GET",
 *        "path"="api/admin/apprenants" ,
 *        "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_CM')",
 *        "security_message"="Vous n'avez pas access à cette Ressource",
 *        "route_name"="apprenant_liste"
 *     },
 *    "get_formateurs"={
 *        "method"="GET",
 *        "path"="/formateurs" ,
 *        "normalization_context"={"groups":"formateur:read"},
 *        "security"="is_granted('ROLE_ADMIN') or is_granted('ROLE_CM')",
 *        "security_message"="Vous n'avez pas access à cette Ressource",
 *        "route_name"="formateur_liste"
 *     },
 *     "post_ajouterApprenant"={
 *        "method"="POST",
 *        "path"="/ajouterApprenant",
 *        "denormalization_context"={"groups":"apprenant:put"},
 *        "access_control"="is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR')",
 *        "access_control_message"="Vous n'avez pas access à cette Ressource",
 *        "route_name"="ajouter_apprenant"
 *      }
 *   },
 *   itemOperations={
 *     "get"={"security"="is_granted('ROLE_ADMIN')",
 *     "path"="/admin/users/{id}"
 *     },
 *     "put"={"security"="is_granted('ROLE_ADMIN')",
 *     "path"="/admin/users/{id}"
 *     },
 *     "delete"={"security"="is_granted('ROLE_ADMIN')",},
 *     "delete_supprimerApprenant"={
 *        "method"="DELETE",
 *        "path"="/supprimerUser/{id}" ,
 *        "normalization_context"={"groups":"apprenant:read"},
 *        "access_control"="(is_granted('ROLE_ADMIN') )",
 *        "access_control_message"="Vous n'avez pas access à cette Ressource",
 *        "route_name"="supprimerUser"
 *     },
 *     "put_modifierApprenant"={
 *        "method"="PUT",
 *        "path"="/modifierApprenant/{id}" ,
 *        "normalization_context"={"groups":"apprenant:read"},
 *        "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_APPRENANT'))",
 *        "access_control_message"="Vous n'avez pas access à cette Ressource",
 *        "route_name"="modifierApprenant",
 *     },
 *    "get_apprenant"={
 *       "method"="GET",
 *       "path"="/apprenant/{id}" ,
 *       "normalization_context"={"groups":"apprenant:read"},
 *       "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_CM') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_APPRENANT'))",
 *       "access_control_message"="Vous n'avez pas access à cette Ressource",
 *       "route_name"="apprenant_liste_one",
 *     },
 *     "get_formateur"={
 *       "method"="GET",
 *       "path"="/formateur/{id}" ,
 *       "normalization_context"={"groups":"formateur:read"},
 *       "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR') or is_granted('ROLE_CM'))",
 *       "access_control_message"="Vous n'avez pas access à cette Ressource",
 *       "route_name"="formateur_liste_one",
 *     },
 *     "put_modifierFormateur"={
 *        "method"="PUT",
 *        "path"="/modifierFormateur/{id}" ,
 *        "normalization_context"={"groups":"formateur:read"},
 *        "access_control"="(is_granted('ROLE_ADMIN') or is_granted('ROLE_FORMATEUR'))",
 *        "access_control_message"="Vous n'avez pas access à cette Ressource",
 *        "route_name"="modifierFormateur",
 *     },
 *   }
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"apprenant:read","getGroupe","showUtil","groupePromo"})
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"apprenant:read","getGroupe","showPromo","groupePromo"})
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Groups({"showUtil"})
     */
    private $email;


    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Groups({"getGroupe","showUtil"})
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"getGroupe","showUtil"})
     */
    private $profil;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"apprenant:read","getGroupe","showUtil","groupePromo"})
     * @Assert\NotBlank()
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"apprenant:read","getGroupe","showUtil","groupePromo"})
     * @Assert\NotBlank()
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Groups({"apprenant:read","getGroupe","showUtil","groupePromo"})
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Groups({"getGroupe","showUtil","groupePromo"})
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=70, nullable=true)
     * @Assert\NotBlank()
     * @Groups({"getGroupe","showUtil","groupePromo"})
     */
    private $genre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank()
     * @Groups({"getGroupe","showUtil","groupePromo"})
     */
    private $login;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=70, nullable=true)
     * @Assert\NotBlank()
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=Promo::class, mappedBy="user", cascade={"persist"})
     */
    private $promos;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $archivage;

    /**
     * @ORM\OneToMany(targetEntity=CommentaireGeneral::class, mappedBy="user")
     */
    private $commentaireGenerals;

    public function __construct()
    {
        $this->promos = new ArrayCollection();
        $this->commentaireGenerals = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $profile=$this->getProfil();
        $p= $profile->getLibelle();
        $rule="ROLE_".strtoupper($p);
        // guarantee every user at least has ROLE_USER
        $roles[] = $rule;

        return array_unique($roles);
    }
    public function getRole(){
        $profile=$this->getProfil();
        $p= $profile->getLibelle();
        $rule="ROLE_".strtoupper($p);
        return $rule;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(?string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getAvatar()
    {
        return (string) $this->avatar;
    }


    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Promo[]
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promos->contains($promo)) {
            $this->promos[] = $promo;
            $promo->setUser($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->contains($promo)) {
            $this->promos->removeElement($promo);
            // set the owning side to null (unless already changed)
            if ($promo->getUser() === $this) {
                $promo->setUser(null);
            }
        }

        return $this;
    }

    public function getArchivage(): ?bool
    {
        return $this->archivage;
    }

    public function setArchivage(?bool $archivage): self
    {
        $this->archivage = $archivage;

        return $this;
    }

    /**
     * @return Collection|CommentaireGeneral[]
     */
    public function getCommentaireGenerals(): Collection
    {
        return $this->commentaireGenerals;
    }

    public function addCommentaireGeneral(CommentaireGeneral $commentaireGeneral): self
    {
        if (!$this->commentaireGenerals->contains($commentaireGeneral)) {
            $this->commentaireGenerals[] = $commentaireGeneral;
            $commentaireGeneral->setUser($this);
        }

        return $this;
    }

    public function removeCommentaireGeneral(CommentaireGeneral $commentaireGeneral): self
    {
        if ($this->commentaireGenerals->contains($commentaireGeneral)) {
            $this->commentaireGenerals->removeElement($commentaireGeneral);
            // set the owning side to null (unless already changed)
            if ($commentaireGeneral->getUser() === $this) {
                $commentaireGeneral->setUser(null);
            }
        }

        return $this;
    }


}
