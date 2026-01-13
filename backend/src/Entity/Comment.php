<?php
// src/Entity/Comment.php
namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV7Generator;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'comments')]
class Comment
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private Uuid $id;

    #[ORM\Column(type: 'text')]
    private string $content;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\ManyToOne(targetEntity: Deal::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private Deal $deal;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $author;

    #[ORM\ManyToMany(targetEntity: User::class)]
    #[ORM\JoinTable(name: 'comment_mentions')]
    private \Doctrine\Common\Collections\Collection $mentionedUsers;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->mentionedUsers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    // ... getters/setters (аналогично)
}