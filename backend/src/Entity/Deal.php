<?php
// src/Entity/Deal.php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV7Generator;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'deals')]
#[ORM\HasLifecycleCallbacks]
class Deal
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private Uuid $id;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $title;

    #[ORM\Column(length: 20, enumType: DealStage::class)]
    private DealStage $stage;

    #[ORM\Column(length: 20, enumType: DealPriority::class)]
    private DealPriority $priority;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 2, nullable: true)]
    private ?string $value = null;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $deadline = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $source = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $company = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $notes = null;

    #[ORM\Column(type: 'json')]
    private array $tags = [];

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $updatedAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $closedAt = null;

    // --- Relations ---
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $createdBy;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $assignedTo;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $contactName;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Assert\Regex('/^\+?[\d\s\-\(\)]+$/')]
    private string $contactPhone;

    #[ORM\Column(length: 255)]
    #[Assert\Email]
    #[Assert\NotBlank]
    private string $contactEmail;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(mappedBy: 'deal', targetEntity: Comment::class, cascade: ['persist', 'remove'])]
    private Collection $comments;

    /**
     * @var Collection<int, File>
     */
    #[ORM\OneToMany(mappedBy: 'deal', targetEntity: File::class, cascade: ['persist', 'remove'])]
    private Collection $files;

    /**
     * @var Collection<int, AuditLog>
     */
    #[ORM\OneToMany(mappedBy: 'deal', targetEntity: AuditLog::class)]
    private Collection $auditLogs;

    public function __construct()
    {
        $this->createdAt = $this->updatedAt = new \DateTimeImmutable();
        $this->stage = DealStage::CONTACT;
        $this->priority = DealPriority::MEDIUM;
        $this->comments = new ArrayCollection();
        $this->files = new ArrayCollection();
        $this->auditLogs = new ArrayCollection();
    }

    #[ORM\PreUpdate]
    public function updateTimestamp(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    // --- Getters & Setters (кратко — только ключевые) ---
    public function getId(): Uuid { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function setTitle(string $title): self { $this->title = $title; return $this; }
    public function getStage(): DealStage { return $this->stage; }
    public function setStage(DealStage $stage): self { $this->stage = $stage; return $this; }
    public function getPriority(): DealPriority { return $this->priority; }
    public function setPriority(DealPriority $priority): self { $this->priority = $priority; return $this; }
    public function getValue(): ?string { return $this->value; }
    public function setValue(?string $value): self { $this->value = $value; return $this; }
    public function getDeadline(): ?\DateTimeImmutable { return $this->deadline; }
    public function setDeadline(?\DateTimeImmutable $deadline): self { $this->deadline = $deadline; return $this; }
    public function getSource(): ?string { return $this->source; }
    public function setSource(?string $source): self { $this->source = $source; return $this; }
    public function getCompany(): ?string { return $this->company; }
    public function setCompany(?string $company): self { $this->company = $company; return $this; }
    public function getNotes(): ?string { return $this->notes; }
    public function setNotes(?string $notes): self { $this->notes = $notes; return $this; }
    public function getTags(): array { return $this->tags; }
    public function setTags(array $tags): self { $this->tags = $tags; return $this; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
    public function getUpdatedAt(): \DateTimeImmutable { return $this->updatedAt; }
    public function getClosedAt(): ?\DateTimeImmutable { return $this->closedAt; }
    public function setClosedAt(?\DateTimeImmutable $closedAt): self { $this->closedAt = $closedAt; return $this; }

    public function getCreatedBy(): User { return $this->createdBy; }
    public function setCreatedBy(User $createdBy): self { $this->createdBy = $createdBy; return $this; }
    public function getAssignedTo(): User { return $this->assignedTo; }
    public function setAssignedTo(User $assignedTo): self { $this->assignedTo = $assignedTo; return $this; }

    public function getContactName(): string { return $this->contactName; }
    public function setContactName(string $contactName): self { $this->contactName = $contactName; return $this; }
    public function getContactPhone(): string { return $this->contactPhone; }
    public function setContactPhone(string $contactPhone): self { $this->contactPhone = $contactPhone; return $this; }
    public function getContactEmail(): string { return $this->contactEmail; }
    public function setContactEmail(string $contactEmail): self { $this->contactEmail = $contactEmail; return $this; }

    public function getComments(): Collection { return $this->comments; }
    public function getFiles(): Collection { return $this->files; }
    public function getAuditLogs(): Collection { return $this->auditLogs; }
}