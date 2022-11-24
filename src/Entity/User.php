<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'dairy_user', targetEntity: Diary::class)]
    private Collection $diary;

    #[ORM\OneToOne(mappedBy: 'tuser', cascade: ['persist', 'remove'])]
    private ?Thread $thread = null;

    #[ORM\OneToOne(mappedBy: 'forUser', cascade: ['persist', 'remove'])]
    private ?UserProfile $userProfile = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\Column(length: 1)]
    private ?string $status = null;

    #[ORM\Column(length: 1)]
    private ?string $type = null;

    public function __construct()
    {
        $this->diary = new ArrayCollection();
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
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Diary>
     */
    public function getDiary(): Collection
    {
        return $this->diary;
    }

    public function addDiary(Diary $diary): self
    {
        if (!$this->diary->contains($diary)) {
            $this->diary->add($diary);
            $diary->setDairyUser($this);
        }

        return $this;
    }

    public function removeDiary(Diary $diary): self
    {
        if ($this->diary->removeElement($diary)) {
            // set the owning side to null (unless already changed)
            if ($diary->getDairyUser() === $this) {
                $diary->setDairyUser(null);
            }
        }

        return $this;
    }

    public function getThread(): ?Thread
    {
        return $this->thread;
    }

    public function setThread(?Thread $thread): self
    {
        // unset the owning side of the relation if necessary
        if ($thread === null && $this->thread !== null) {
            $this->thread->setTuser(null);
        }

        // set the owning side of the relation if necessary
        if ($thread !== null && $thread->getTuser() !== $this) {
            $thread->setTuser($this);
        }

        $this->thread = $thread;

        return $this;
    }

    public function getUserProfile(): ?UserProfile
    {
        return $this->userProfile;
    }

    public function setUserProfile(UserProfile $userProfile): self
    {
        // set the owning side of the relation if necessary
        if ($userProfile->getForUser() !== $this) {
            $userProfile->setForUser($this);
        }

        $this->userProfile = $userProfile;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
