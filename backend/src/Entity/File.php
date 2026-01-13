<?php
// src/Entity/File.php
namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV7Generator;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'files')]
class File
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private Uuid $id;

    #[ORM\Column(length: 255)]
    private string $originalName;

    #[ORM\Column(length: 100)]
    private string $mimeType;

    #[ORM\Column(type: 'integer')]
    private int $size;

    #[ORM\Column(length: 500)]
    private string $storagePath; // e.g. "deals/123/report.pdf"

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $uploadedAt;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $uploadedBy;

    #[ORM\ManyToOne(targetEntity: Deal::class, inversedBy: 'files')]
    #[ORM\JoinColumn(nullable: false)]
    private Deal $deal;

    #[ORM\ManyToOne(targetEntity: Comment::class, inversedBy: 'files')]
    private ?Comment $comment = null;

    public function __construct()
    {
        $this->uploadedAt = new \DateTimeImmutable();
    }

    // ... getters/setters
}