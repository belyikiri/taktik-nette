<?php
declare(strict_types=1);

namespace App\Models;

use DateTime;

class Survey
{
    private int $id;
    private string $name;
    private string $comment;
    private bool $isAgreed;
    private Datetime $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function isAgreed(): bool
    {
        return $this->isAgreed;
    }

    public function setIsAgreed(bool $isAgreed): void
    {
        $this->isAgreed = $isAgreed;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
