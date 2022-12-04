<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

trait EntityIdTrait {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id;

    #[ORM\Column(type: 'uuid', unique: true)]
    protected UuidInterface $uuid;

    public function getId() : ?int {
        return $this->id;
    }

    public function getUuid() : UuidInterface {
        return $this->uuid;
    }
}