<?php
// src/Entity/User.php
namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV7Generator;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Groups(['deal:read'])]
    #[ORM\Id, ORM\Column(type: 'uuid'), ORM\GeneratedValue]
    private Uuid $id;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email]
    #[Assert\NotBlank]
    private string $email;

    #[ORM\Column]
    private string $password;

    #[Groups(['deal:read'])]
    #[ORM\Column(length: 255)]
    private string $fullName;

    #[ORM\Column(length: 20, enumType: UserRole::class)]
    private UserRole $role;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $oauthProvider = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $lastLoginAt = null;

    /**
     * @var Collection<int, Deal>
     */
    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Deal::class)]
    private Collection $createdDeals;

    /**
     * @var Collection<int, Deal>
     */
    #[ORM\OneToMany(mappedBy: 'assignedTo', targetEntity: Deal::class)]
    private Collection $assignedDeals;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Comment::class)]
    private Collection $comments;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->createdDeals = new ArrayCollection();
        $this->assignedDeals = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->role = UserRole::SALES_MANAGER;
    }

    // --- Getters & Setters ---
    public function getId(): Uuid { return $this->id; }
    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }
    public function getPassword(): string { return $this->password; }
    public function setPassword(string $password): self { $this->password = $password; return $this; }
    public function getFullName(): string { return $this->fullName; }
    public function setFullName(string $fullName): self { $this->fullName = $fullName; return $this; }
    public function getRole(): UserRole { return $this->role; }
    public function setRole(UserRole $role): self { $this->role = $role; return $this; }
    public function getOauthProvider(): ?string { return $this->oauthProvider; }
    public function setOauthProvider(?string $oauthProvider): self { $this->oauthProvider = $oauthProvider; return $this; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
    public function getLastLoginAt(): ?\DateTimeImmutable { return $this->lastLoginAt; }
    public function setLastLoginAt(\DateTimeImmutable $lastLoginAt): self { $this->lastLoginAt = $lastLoginAt; return $this; }

    // --- UserInterface ---
    public function getUserIdentifier(): string { return $this->email; }
    public function getUsername(): string { return $this->email; }
    public function getRoles(): array { return [$this->role->value]; }
    public function eraseCredentials(): void {}

    // --- Relations ---
    public function getCreatedDeals(): Collection { return $this->createdDeals; }
    public function getAssignedDeals(): Collection { return $this->assignedDeals; }
    public function getComments(): Collection { return $this->comments; }
}