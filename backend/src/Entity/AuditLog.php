<?php
// src/Entity/AuditLog.php
namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV7Generator;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'audit_logs')]
class AuditLog
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private Uuid $id;

    #[ORM\Column(length: 50)] // 'Deal'
    private string $entity;

    #[ORM\Column(type: 'uuid')]
    private Uuid $entityId;

    #[ORM\Column(length: 50)] // 'update_stage', 'add_comment'...
    private string $action;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $oldValue = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $newValue = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $changedBy;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $changedAt;

    public function __construct()
    {
        $this->changedAt = new \DateTimeImmutable();
    }

    // ... getters/setters
}