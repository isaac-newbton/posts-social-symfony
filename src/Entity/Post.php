<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    use EntityIdTrait;

    #[ORM\Column(length: 140)]
    private ?string $content = null;

    #[ORM\Column(enumType: PostStatus::class)]
    private PostStatus $status;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $time = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AppUser $author = null;

    #[ORM\Column]
    private int $views = 0;

    #[ORM\Column]
    private int $impressions = 0;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
        $this->status = PostStatus::PUBLIC;
    }

    public function setStatus(PostStatus $status): self {
        $this->status = $status;
        return $this;
    }

    public function getStatus(): PostStatus {
        return $this->status;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getAuthor(): ?AppUser
    {
        return $this->author;
    }

    public function setAuthor(?AppUser $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(int $views): self
    {
        $this->views = $views;

        return $this;
    }

    public function getImpressions(): ?int
    {
        return $this->impressions;
    }

    public function setImpressions(int $impressions): self
    {
        $this->impressions = $impressions;

        return $this;
    }
}
